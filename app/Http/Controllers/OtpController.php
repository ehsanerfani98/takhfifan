<?php

namespace App\Http\Controllers;

use App\Mail\PasswordMail;
use App\Models\User;
use App\Services\Ippanel\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Cache, Log, Hash, Mail, Validator};

class OtpController extends Controller
{
    public function __construct(protected OtpService $otpService)
    {
    }

    public function send(Request $request)
    {
        $type = get_setting('login_type'); // 'mobile' or 'email'
        $input = $request->input('input');

        if ($request->has('status')) {
            $validator = Validator::make($request->all(), [
                'input' => 'required|regex:/^09\d{9}$/'
            ]);

            if ($validator->fails()) {
                return $this->validationError($validator, 'شماره موبایل');
            }

            $result = $this->otpService->send($input);
            return $result['success']
                ? response()->json($result)
                : response()->json($result, 500);
        }

        $validator = Validator::make($request->all(), [
            'input' => $type === 'mobile'
                ? 'required|regex:/^09\d{9}$/'
                : 'required|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator, $type === 'mobile' ? 'شماره موبایل' : 'ایمیل');
        }

        if ($type === 'mobile') {
            $result = $this->otpService->send($input);

            return $result['success']
                ? response()->json($result)
                : response()->json($result, 500);
        }

        try {
            if ($this->existUser('email', $input)) {
                return response()->json(['success' => true, 'status' => 'exist_email', 'message' => 'رمز عبور خود را وارد کنید.']);
            }

            $password = generateRandomString(10);
            $user = User::create([
                'email' => $input,
                'password' => Hash::make($password)
            ]);
            $user->assignRole('User');

            Mail::to($input)->send(new PasswordMail($password));

            return response()->json(['success' => true, 'status' => 'new_email', 'message' => 'رمز عبور با موفقیت ایمیل شد.']);
        } catch (\Exception $e) {
            User::where('email', $input)->delete();
            return response()->json([
                'success' => false,
                'message' => 'خطا در ارسال ایمیل، مجدد تلاش کنید',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $type = get_setting('login_type');
        $input = $request->input('input');
        $code = $request->input('code');

        if ($request->has('status')) {
            $validator = Validator::make($request->all(), [
                'input' => 'required|regex:/^09\d{9}$/',
                'code' => 'required|digits:6',
            ]);

            if ($validator->fails()) {
                return $this->validationError($validator, 'شماره موبایل');
            }

            $result = $this->otpService->verify($input, $code);
            if (!$result['success']) {
                return response()->json($result, 400);
            }

            $user = User::find(auth()->id());
            $user?->update(['phone' => $input]);

            return response()->json([
                'success' => true,
                'message' => 'شماره موبایل با موفقیت تایید شد',
            ]);
        }

        if ($type === 'mobile') {
            $validator = Validator::make($request->all(), [
                'input' => 'required|regex:/^09\d{9}$/',
                'code' => 'required|digits:6',
            ]);

            if ($validator->fails()) {
                return $this->validationError($validator, 'شماره موبایل');
            }

            $result = $this->otpService->verify($input, $code);
            if (!$result['success']) {
                return response()->json($result, 400);
            }

            return $this->loginOrCreateUser('phone', $input);
        }

        // ایمیل
        $validator = Validator::make($request->all(), [
            'input' => 'required|email|regex:/@gmail\.com$/i',
            'code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator, 'ایمیل');
        }

        if (Cache::get("email_$input") !== $code) {
            return response()->json([
                'success' => false,
                'message' => 'کد تایید اشتباه است یا منقضی شده',
            ], 400);
        }

        return $this->loginOrCreateUser('email', $input);
    }

    public function sendPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'رمز عبور نامعتبر است'
            ], 401);
        }

        Auth::login($user);
        return $this->successResponse('ورود با موفقیت انجام شد');
    }

    protected function loginOrCreateUser(string $field, string $value)
    {
        if (!$this->existUser($field, $value)) {
            $user = User::create([$field => $value, 'password' => null]);
            $user->assignRole('User');
        } else {
            $user = User::where($field, $value)->first();
        }

        Auth::login($user);
        return $this->successResponse('ورود با موفقیت انجام شد');
    }

    protected function successResponse(string $message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'redirect' => route('dashboard'),
        ]);
    }

    protected function validationError($validator, $fieldName)
    {
        return response()->json([
            'success' => false,
            'message' => "$fieldName نامعتبر است",
            'errors' => $validator->errors(),
        ], 422);
    }

    /**
     * بررسی وجود کاربر بر اساس فیلد و مقدار
     */
    protected function existUser(string $field, string $value): bool
    {
        return User::where($field, $value)->exists();
    }
}
