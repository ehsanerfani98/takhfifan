<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Contract\Messaging;

class EventService
{
    private Messaging $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function processEvents()
    {
        $now = Carbon::now();

        // فقط رکوردهایی که هنوز ارسال یا یادآوری نشده‌اند بررسی می‌شوند
        $events = Event::where(function ($query) use ($now) {
            $query->where('status', '!=', 'sent')
                ->where('send_date', '<=', $now);
        })
            ->orWhere(function ($query) use ($now) {
                $query->where('status_remind', '!=', 'sent')
                    ->where('remind_at', '<=', $now);
            })
            ->get();

        foreach ($events as $event) {
            DB::beginTransaction();

            try {
                // ارسال اصلی
                if ($event->status !== 'sent' && $event->send_date <= $now) {
                    $success = $this->send_sms($event, 'send');

                    if ($success) {
                        $event->status = 'sent';
                    } else {
                        $event->status = 'failed';
                        throw new \Exception("Failed to send main SMS.");
                    }
                }

                // یادآوری
                if ($event->status_remind !== 'sent' && $event->remind_at <= $now) {
                    $success = $this->send_sms($event, 'remind');

                    if ($success) {
                        $event->status_remind = 'sent';
                    } else {
                        $event->status_remind = 'failed';
                        throw new \Exception("Failed to send reminder SMS.");
                    }
                }

                $event->save();
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error("Error processing event ID {$event->id}: " . $e->getMessage());
                // در صورت نیاز، می‌توانید وضعیت‌ها را به pending برگردانید:
                // $event->status = 'pending';
                // $event->status_remind = 'pending';
                // $event->save();
            }
        }
    }

   private function send_sms(Event $event, $type)
{
    try {
        $event->load('user', 'contact');

        $message = CloudMessage::new()
            ->withNotification([
                'title' => $event->title,
                'body'  => $event->notes,
            ]);

        // تعیین token بر اساس نوع
        $tokens = [];

        if ($type == 'send') {
            $phone = $event->contact->phone;
            $user = User::where('phone', $phone)->first();
            if ($user && $user->device_token) {
                $tokens[] = $user->device_token;
            }
            
            
              // اگر توکنی پیدا نشد
        if (empty($tokens)) {
            Log::warning("No valid device token for event {$event->id}");
            return false;
        }

        // ارسال به صورت multicast (حتی اگر فقط یک token داشته باشیم)
        $report = $this->messaging->sendMulticast($message, $tokens);

        // بررسی وضعیت موفقیت/شکست
        if ($report->hasFailures()) {
            foreach ($report->failures()->getItems() as $failure) {
                Log::error("FCM send failure for event {$event->id}: " . $failure->error()->getMessage());
            }
            return false;
        }

        // ثبت Notification در دیتابیس
        Notification::create([
            'title'     => $event->title,
            'body'      => $event->notes,
            'receivers' => serialize($tokens),
        ]);
            
        }

        if ($type == 'remind' && $event->user && $event->user->device_token) {
            $tokens[] = $event->user->device_token;
            
            
              // اگر توکنی پیدا نشد
        if (empty($tokens)) {
            Log::warning("No valid device token for event {$event->id}");
            return false;
        }

        // ارسال به صورت multicast (حتی اگر فقط یک token داشته باشیم)
        $report = $this->messaging->sendMulticast($message, $tokens);

        // بررسی وضعیت موفقیت/شکست
        if ($report->hasFailures()) {
            foreach ($report->failures()->getItems() as $failure) {
                Log::error("FCM send failure for event {$event->id}: " . $failure->error()->getMessage());
            }
            return false;
        }

        // ثبت Notification در دیتابیس
        Notification::create([
            'title'     => $event->title,
            'body'      => $event->notes,
            'receivers' => serialize($tokens),
        ]);
        }

      

        return true; // موفقیت واقعی
    } catch (\Throwable $e) {
        Log::error("SMS send failed for event {$event->id}: " . $e->getMessage());
        return false;
    }
}

}
