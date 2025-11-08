<?php

namespace App\Services\TelegramService;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $botToken;
    protected string $proxyUrl;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->proxyUrl = env('TELEGRAM_PROXY_URL');
    }

    /**
     * ارسال درخواست به API تلگرام
     */
    protected function request(string $method, array $parameters = []): array
    {
        $args = [
            'bot_token' => $this->botToken,
            'method'    => $method,
        ];

        if (!empty($parameters)) {
            $args['args'] = json_encode($parameters);
        }

        $response = Http::withoutVerifying()->asForm()->post($this->proxyUrl, $args);

        return $response->json();
    }

    /**
     * 📩 ارسال پیام متنی
     */
    public function sendMessage(int|string $chatId, string $text): array
    {
        return $this->request('sendMessage', [
            'chat_id' => $chatId,
            'text'    => $text,
        ]);
    }

    /**
     * 📷 ارسال عکس
     */
    public function sendPhoto(int|string $chatId, string $photoUrl, string $caption = ''): array
    {
        return $this->request('sendPhoto', [
            'chat_id' => $chatId,
            'photo'   => $photoUrl,
            'caption' => $caption,
        ]);
    }

    /**
     * 🎬 ارسال ویدئو
     */
    public function sendVideo(int|string $chatId, string $videoUrl, string $caption = ''): array
    {
        return $this->request('sendVideo', [
            'chat_id' => $chatId,
            'video'   => $videoUrl,
            'caption' => $caption,
        ]);
    }

    /**
     * 📁 ارسال فایل
     */
    public function sendDocument(int|string $chatId, string $documentUrl, string $caption = ''): array
    {
        return $this->request('sendDocument', [
            'chat_id'  => $chatId,
            'document' => $documentUrl,
            'caption'  => $caption,
        ]);
    }

    /**
     * 🔊 ارسال فایل صوتی (voice)
     */
    public function sendVoice(int|string $chatId, string $voiceUrl, string $caption = ''): array
    {
        return $this->request('sendVoice', [
            'chat_id' => $chatId,
            'voice'   => $voiceUrl,
            'caption' => $caption,
        ]);
    }

    /**
     * 🎵 ارسال موزیک (audio)
     */
    public function sendAudio(int|string $chatId, string $audioUrl, string $caption = ''): array
    {
        return $this->request('sendAudio', [
            'chat_id' => $chatId,
            'audio'   => $audioUrl,
            'caption' => $caption,
        ]);
    }

    /**
     * 📍 ارسال لوکیشن
     */
    public function sendLocation(int|string $chatId, float $latitude, float $longitude): array
    {
        return $this->request('sendLocation', [
            'chat_id'   => $chatId,
            'latitude'  => $latitude,
            'longitude' => $longitude,
        ]);
    }

    /**
     * 🆔 گرفتن آپدیت‌ها (برای دیدن chat_id و آخرین پیام‌ها)
     */
    public function getUpdates(): array
    {
        return $this->request('getUpdates');
    }

    /**
     * ✏️ ویرایش پیام متنی
     */
    public function editMessage(int|string $chatId, int $messageId, string $newText): array
    {
        return $this->request('editMessageText', [
            'chat_id'    => $chatId,
            'message_id' => $messageId,
            'text'       => $newText,
        ]);
    }

    /**
     * 🗑️ حذف پیام
     */
    public function deleteMessage(int|string $chatId, int $messageId): array
    {
        return $this->request('deleteMessage', [
            'chat_id'    => $chatId,
            'message_id' => $messageId,
        ]);
    }

    public function handleUpdate(array $update)
    {

        // لاگ کردن اطلاعات کاربر
        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'] ?? null;
            $firstName = $message['chat']['first_name'] ?? '';
            $lastName = $message['chat']['last_name'] ?? '';
            $username = $message['chat']['username'] ?? '';
            $text = $message['text'] ?? '';

            // Log::info("Telegram Update Received", [
            //     'chat_id' => $chatId,
            //     'first_name' => $firstName,
            //     'last_name' => $lastName,
            //     'username' => $username,
            //     'text' => $text,
            // ]);

            // پاسخ به دستور /start
            if ($text === '/start' && $chatId) {
                $this->sendMessage($chatId, "سلام $firstName عزیز! خوش آمدی به ربات ما 🌟" . $text);
            }
            if ($text === '/code' && $chatId) {
                $this->sendMessage($chatId, "شناسه خود را وارد کنید.");
            }
        }
    }
}
