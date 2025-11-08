<?php

namespace App\Services\Ippanel;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OtpService
{
    protected $apiKey;
    protected $originator;
    protected $patternCode;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = get_setting('apiKey');
        $this->originator = get_setting('originator');
        $this->patternCode = get_setting('patternCode');
        $this->baseUrl = 'https://edge.ippanel.com/v1/api/send';
    }

    public function send(string $phone): array
    {
        try {
            $phone = $this->normalizephone($phone);
            $code = generateCode();
            $this->storeCode($phone, $code);

            if (boolval(get_setting('sms_status'))) {
                return [
                    'success' => true,
                    'code' => $code
                ];
            }

            $response = $this->sendSms($phone, $code);

            return [
                'success' => true,
                'message' => 'کد تایید با موفقیت ارسال شد',
                'data' => [
                    'reference_id' => $response['reference_id'] ?? null,
                    'expires_in' => 120
                ]
            ];
        } catch (Exception $e) {
            Log::error('OTP send error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'خطا در ارسال کد تایید',
                'error' => $e->getMessage()
            ];
        }
    }

    public function verify(string $phone, string $code): array
    {
        $phone = $this->normalizephone($phone);
        $cachedCode = $this->getCode($phone);

        if (!$cachedCode) {
            return [
                'success' => false,
                'message' => 'کد تایید منقضی شده است'
            ];
        }

        if ($cachedCode !== $code) {
            return [
                'success' => false,
                'message' => 'کد تایید اشتباه است'
            ];
        }

        $this->clearCode($phone);

        return [
            'success' => true,
            'message' => 'کد تایید با موفقیت تایید شد',
            'redirect' => route('dashboard')
        ];
    }

    protected function storeCode(string $phone, string $code): void
    {
        Cache::put('otp_' . $phone, $code, now()->addMinutes(2));
    }

    protected function getCode(string $phone): ?string
    {
        return Cache::get('otp_' . $phone);
    }

    protected function clearCode(string $phone): void
    {
        Cache::forget('otp_' . $phone);
    }

    protected function normalizephone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (strlen($phone) === 10 && substr($phone, 0, 1) === '9') {
            $phone = '98' . $phone;
        } elseif (strlen($phone) === 11 && substr($phone, 0, 2) === '09') {
            $phone = '98' . substr($phone, 1);
        }

        return $phone;
    }

    protected function sendSms(string $phone, string $code): array
    {

        $token = $this->apiKey;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'sending_type' => 'pattern',
                'from_number' => $this->originator,
                'code' => $this->patternCode,
                'recipients' => [
                    $phone
                ],
                'params' => [
                    'verification-code' => $code
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: $token",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $responseBody = json_decode($response, true);

        return $responseBody;
    }
}
