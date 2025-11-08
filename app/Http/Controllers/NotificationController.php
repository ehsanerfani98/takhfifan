<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Contract\Messaging;

class NotificationController extends Controller
{
    public function create()
    {
        $users = User::whereNotNull('device_token')->get();
        $roles = Role::pluck('title', 'name')->all();
        return view('admin.notifications.notification', compact('users', 'roles'));
    }

    public function saveToken(Request $request)
    {
        Auth::user()->update(['device_token' => $request->token]);
        return response()->json(['message' => 'Token saved successfully.']);
    }

    public function sendNotification(Request $request, Messaging $messaging)
    {
        $request->validate([
            'title'  => 'required|string',
            'body'   => 'required|string',
            'roles'  => 'nullable|array',
            'tokens' => 'nullable|array',
        ]);

        if (isset($request->roles) && !empty($request->roles)) {
            $tokens = [];
            $users = User::all();
            foreach ($request->roles as $role) {
                foreach ($users as $user) {
                    if ($user->hasRole($role)) {
                        if (!is_null($user->device_token) && !empty($user->device_token)) {
                            $tokens[] = $user->device_token;
                        }
                    }
                }
            }
            $tokens = array_unique($tokens);
        } else {
            $tokens = $request->tokens;
        }


        if (empty($tokens)) {
            return response()->json(['error' => 'هیچ دستگاهی برای ارسال پیدا نشد.'], 400);
        }

        // ساخت پیام پایه
        $message = CloudMessage::new()
            ->withNotification(\Kreait\Firebase\Messaging\Notification::create(
                $request->title,
                $request->body
            ));

        // ارسال
        $successCount = 0;
        $failureCount = 0;
        $errors = [];

        if (count($tokens) === 1) {
            $message = $message->toToken($tokens[0]);
            $result = $messaging->send($message);
            $successCount = is_string($result) ? 1 : 0;
        } else {
            $sendReport = $messaging->sendMulticast($message, $tokens);
            if (! $sendReport instanceof \Kreait\Firebase\Messaging\MulticastSendReport) {
                throw new \LogicException('sendMulticast returned unexpected type: ' . gettype($sendReport));
            }
            $successCount = $sendReport->successes()->count();
            $failureCount = $sendReport->failures()->count();
            $errors = $sendReport->failures()->getItems();
        }

        Notification::create([
            'title'     => $request->title,
            'body'      => $request->body,
            'receivers' => serialize($tokens),
        ]);

        return response()->json(compact('successCount', 'failureCount', 'errors'));
    }


    public function archive()
    {
        $notifications = Notification::latest()->get();
        return view('admin.notifications.notification_archive', compact('notifications'));
    }
}
