<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Ippanel\OtpService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class OtpLoginController extends Controller
{
    protected $otpService;
    
    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    
    /**
     * نمایش فرم ورود
     */
    public function showLoginForm()
    {
        return view('auth.otp-login');
    }
    
    /**
     * نمایش فرم ثبت‌نام تکمیلی
     */
    public function showRegistrationForm()
    {
        return view('auth.otp-register');
    }
    
    /**
     * ارسال کد تایید
     */
    public function requestOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^[0][9][0-9]{9,9}$/',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'شماره موبایل نامعتبر است',
            ], 422);
        }
        
        $phone = $request->input('phone');
        
        // ارسال کد تایید
        $result = $this->otpService->send($phone);
        
        return response()->json($result);
    }
    
    /**
     * تایید کد و ورود یا ثبت‌نام کاربر
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^[0][9][0-9]{9,9}$/',
            'code' => 'required|digits:6',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات ارسالی نامعتبر است',
            ], 422);
        }
        
        $phone = $request->input('phone');
        $code = $request->input('code');
        
        // تایید کد
        $result = $this->otpService->verify($phone, $code);
        
        if (!$result['success']) {
            return response()->json($result, 400);
        }
        
        // بررسی وجود کاربر
        $user = User::where('phone', $phone)->first();
        
        // اگر کاربر قبلا ثبت‌نام کرده بود
        if ($user && $user->name && $user->email) {
            // ورود کاربر
            Auth::login($user);
            
            return response()->json([
                'success' => true,
                'message' => 'ورود با موفقیت انجام شد',
                'redirect' => route('dashboard')
            ]);
        } 
        // اگر کاربر وجود داشت ولی اطلاعات کامل نبود
        elseif ($user) {
            // ذخیره شماره موبایل در سشن برای استفاده در فرم ثبت‌نام
            session(['registered_phone' => $phone]);
            
            return response()->json([
                'success' => true,
                'message' => 'لطفا اطلاعات کاربری خود را تکمیل کنید',
                'redirect' => route('otp.register')
            ]);
        } 
        // اگر کاربر جدید بود
        else {
            // ایجاد کاربر موقت با اطلاعات حداقلی
            $user = User::create([
                'phone' => $phone,
                'name' => null,
                'email' => null,
                'password' => bcrypt(rand(100000, 999999)),
            ]);
            
            // ذخیره شماره موبایل در سشن برای استفاده در فرم ثبت‌نام
            session(['registered_phone' => $phone]);
            
            return response()->json([
                'success' => true,
                'message' => 'لطفا اطلاعات کاربری خود را تکمیل کنید',
                'redirect' => route('otp.register')
            ]);
        }
    }
    
    /**
     * تکمیل ثبت‌نام کاربر
     */
    public function completeRegistration(Request $request)
    {
        // بررسی وجود شماره موبایل در سشن
        if (!session('registered_phone')) {
            return redirect()->route('login')
                ->with('error', 'لطفا ابتدا از طریق ورود با شماره موبایل اقدام کنید');
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'check1' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // یافتن و به‌روزرسانی کاربر
        $user = User::where('phone', session('registered_phone'))->first();
        
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'خطایی رخ داده است. لطفا مجددا تلاش کنید');
        }
        
        // به‌روزرسانی اطلاعات کاربر
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'email_verified_at' => Carbon::now(),
            'username' => $request->input('username'),
            'user_role' => 'general',
            'status' => 1,
            'lastActive' => Carbon::now()
        ]);
        
        // ورود کاربر
        Auth::login($user);
        
        // پاک کردن سشن
        session()->forget('registered_phone');
        
        return redirect()->route('dashboard');
    }
}