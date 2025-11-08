<?php

use App\Models\Banner;
use App\Models\Conversation;
use App\Models\Discount;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Brand;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Useddiscount;
use App\Models\User;
use App\Models\Car;
use App\Models\UserSubscriptionUsage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Resources\CarResource;
use App\Models\Attribute;
use App\QueryBuilder\Filters\BrandFilter;
use App\QueryBuilder\Filters\CarFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

// if (!function_exists('getRoles')) {
//     function getRoles()
//     {
//         return Auth::user()->roles->pluck('name');
//     }
// }

// if (!function_exists('getPermissions')) {
//     function getPermissions()
//     {
//         return Auth::user()->permissions->pluck('name');
//     }
// }

if (!function_exists('isCompletedInfo')) {
    function isCompletedInfo()
    {
        $info = Auth::user()->additionalinformation;
        if ($info && !empty($info->job) && !empty($info->economic_unit) && !empty($info->ceo_name)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key)
    {
        if ($setting = Setting::where('key', $key)->first()) {
            return $setting->value;
        }

        return false;
    }
}

if (!function_exists('get_settings')) {
    function get_settings()
    {
        if ($setting = Setting::all()) {
            return $setting;
        }
    }
}

if (!function_exists('insert_setting')) {
    function insert_setting($key, $value)
    {
        $setting = new Setting();
        $setting->key = $key;
        $setting->value = $value;
        if ($setting->save()) {
            return true;
        }
    }
}

if (!function_exists('update_setting')) {
    function update_setting($key, $value)
    {
        if ($setting = Setting::where('key', $key)->first()) {
            $setting->value = $value;
        } else {
            $setting = new Setting();
            $setting->key = $key;
            $setting->value = $value;
        }
        if ($setting->save()) {
            return true;
        }
    }
}

if (!function_exists('get_setting_collection')) {
    function get_setting_collection($settings, $key)
    {
        if ($option = $settings->where('key', $key)->first()) {
            return $option->value;
        }

        return false;
    }
}

if (!function_exists('send_sms')) {
    function send_sms($mobile, $message)
    {

        $user = 'webcomnaghilo';
        $pass = 'webcomco1403';
        $fromNum = '+985000404223';
        $input_data = array(
            'verification-code' => $message,
        );
        $rcpt_nm = array($mobile);
        $pattern_code = 'zj9xvrhyabn5vnx';

        $url = 'https://ippanel.com/patterns/pattern?username=' . $user . '&password=' . urlencode($pass) . '&from=' . $fromNum . '&to=' . json_encode($rcpt_nm) . '&input_data=' . urlencode(json_encode($input_data)) . '&pattern_code=' . $pattern_code;
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
    }
}

if (!function_exists('get_table_list')) {
    function get_table_list($model_name, $is_active = false, $parent = false)
    {
        $modelClass = "App\\Models\\$model_name";

        if (class_exists($modelClass)) {
            $query = $modelClass::query();

            if ($is_active) {
                $query->where('is_active', 1);
            }

            if ($parent) {
                $query->whereNotNull('parent_id');
            } else {
                $query->whereNull('parent_id');
            }

            return $query->get();
        }

        return collect();
    }
}

if (!function_exists('emptyDoc')) {
    function emptyDoc()
    {
        $user = Auth::user()->load('document');
        $doc = $user->document;

        if (!$doc)
            return true;

        if ($doc->needs_correction)
            return true;

        $requiredFields = match ($doc->type) {
            'real' => ['type', 'first_name', 'last_name', 'mobile', 'national_id'],
            'legal' => ['type', 'first_name', 'last_name', 'mobile', 'national_id', 'company_name', 'company_address'],
            default => [],
        };

        foreach ($requiredFields as $field) {
            if (empty($doc->$field)) {
                return true;
            }
        }

        if (!$doc->is_verified)
            return true;

        return false;
    }
}


if (!function_exists('isConfirmDoc')) {
    function isConfirmDoc()
    {
        $status = false;
        $user = Auth::user()->load('document');
        $doc = $user->document;
        if (!$doc) {
            return true;
        }
        $requiredFields = match ($doc->type) {
            'real' => ['type', 'first_name', 'last_name', 'mobile', 'national_id'],
            'legal' => ['type', 'first_name', 'last_name', 'mobile', 'national_id', 'company_name', 'company_address'],
            default => [],
        };

        foreach ($requiredFields as $field) {
            if (empty($doc->$field)) {
                $status = true;
                break;
            }
        }

        if (!$status) {
            if (!$doc->is_verified && !$doc->needs_correction) {
                return false;
            }
            if ($doc->needs_correction) {
                return true;
            }
        }

        return true;
    }
}


if (!function_exists('remainingDays')) {
    function remainingDays()
    {
        $remainingDays = Carbon::parse(now())->diffInDays(getCurrentSubscript()->ends_at);

        return round($remainingDays);
    }
}

if (!function_exists('getCurrentSubscript')) {
    function getCurrentSubscript()
    {
        $activeSubscription = auth()->user()->subscriptions()
            ->with('subscription')
            ->where('ends_at', '>', now())
            ->whereHas('payment', fn($q) => $q->where('status', 'paid'))
            ->latest('ends_at')
            ->first();

        return $activeSubscription;
    }
}

if (!function_exists('walletBalance')) {
    function walletBalance(User $user)
    {

        $wallet = $user->wallet;

        if (!$wallet) {
            return 0;
        }

        return $wallet->balance;
    }
}

if (!function_exists('chargeWallet')) {
    function chargeWallet(Payment $payment)
    {
        $user = auth()->user();

        $wallet = $user->wallet()->firstOrCreate(['user_id' => $user->id]);

        $wallet->increment('balance', $payment->amount);

        $wallet->transactions()->create([
            'type' => 'credit',
            'amount' => $payment->amount,
            'payment_id' => $payment->id,
            'description' => 'شارژ کیف پول',
        ]);
    }
}

if (!function_exists('useWallet')) {
    function useWallet(int $amount, string $description = 'خرید از کیف پول', ?Payment $payment = null)
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        if (!$wallet || $wallet->balance < $amount) {
            return false;
        }

        DB::transaction(function () use ($wallet, $amount, $description, $payment) {
            $wallet->decrement('balance', $amount);
            $wallet->transactions()->create([
                'type' => 'debit',
                'amount' => $amount,
                'payment_id' => $payment?->id,
                'description' => $description,
            ]);
        });

        return true;
    }
}

if (!function_exists('getSliders')) {
    function getSliders()
    {
        return Slider::where('is_active', true)
            ->orderBy('order', 'desc')
            ->get();
    }
}

if (!function_exists('getBanners')) {
    function getBanners()
    {
        return Banner::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
    }
}

if (!function_exists('getKeywordCar')) {
    function getKeywordCar()
    {
        return Car::where('keyword', true)->get();
    }
}

if (!function_exists('getCountCars')) {
    function getCountCars($url)
    {
        try {
            $parsedUrl = parse_url($url);
            if (!isset($parsedUrl['query'])) {
                return 0;
            }

            $queryString = $parsedUrl['query'];
            parse_str($queryString, $filters);

            $attributeFilters = Attribute::where('is_active', 1)->pluck('slug')
                ->map(fn($slug) => AllowedFilter::custom($slug, new CarFilter()))
                ->toArray();

            $brandFilter = AllowedFilter::custom('brand', new BrandFilter());
            $allowedFilters = array_merge($attributeFilters, [$brandFilter]);

            $query = QueryBuilder::for(Car::class, request()->merge($filters))
                ->allowedFilters($allowedFilters);

            return $query->count();
        } catch (Exception $e) {
            // لاگ خطا یا return 0
            return 0;
        }
    }
}

if (!function_exists('currency')) {
    function currency()
    {
        $currency = get_setting('currency');
        return $currency;
    }
}

if (!function_exists('trackDiscountUsage')) {
    function trackDiscountUsage($code)
    {
        try {
            $discount = Discount::where('code', $code)
                ->where('status', 'enable')
                ->whereDate('expiration', '>=', now())
                ->first();

            if (!$discount) {
                return;
            }

            $userId = Auth::id();
            $limit = $discount->limitdiscount;

            if (
                $discount->access === 'private' &&
                !in_array($userId, $discount->user_ids ?? [])
            ) {
                return;
            }

            DB::transaction(function () use ($userId, $discount, $limit) {
                $usedDiscount = Useddiscount::firstOrNew([
                    'user_id' => $userId,
                    'discount_id' => $discount->id
                ]);

                if ($limit > 0 && $usedDiscount->used >= $limit) {
                    return;
                }

                $usedDiscount->used = ($usedDiscount->used ?? 0) + 1;
                $usedDiscount->save();
            });
        } catch (Exception $e) {
            Log::error("Failed to register discount usage", [
                'code' => $code,
                'error' => $e->getMessage()
            ]);
        }
    }
}

if (!function_exists('applyDiscount')) {
    function applyDiscount(float $originalAmount, string $discountCode): array
    {
        try {
            $discount = Discount::where('code', $discountCode)
                ->where('status', 'enable')
                ->whereDate('expiration', '>=', now())
                ->first();

            if (!$discount) {
                return [
                    'original' => $originalAmount,
                    'discount' => 0,
                    'final' => $originalAmount,
                    'valid' => false
                ];
            }

            $userId = Auth::id();

            if ($discount->limitdiscount > 0) {
                $usedCount = Useddiscount::where('user_id', $userId)
                    ->where('discount_id', $discount->id)
                    ->value('used') ?? 0;

                if ($usedCount >= $discount->limitdiscount) {
                    return [
                        'original' => $originalAmount,
                        'discount' => 0,
                        'final' => $originalAmount,
                        'valid' => false
                    ];
                }
            }

            if ($discount->access === 'private' && !in_array($userId, $discount->user_ids ?? [])) {
                return [
                    'original' => $originalAmount,
                    'discount' => 0,
                    'final' => $originalAmount,
                    'valid' => false
                ];
            }

            $discountValue = ($discount->getRawOriginal('type') === 'percent')
                ? round(($originalAmount * $discount->percent) / 100, 2)
                : round($discount->amount, 2);

            $finalAmount = max(round($originalAmount - $discountValue, 2), 0);

            return [
                'original' => $originalAmount,
                'discount' => $discountValue,
                'final' => $finalAmount,
                'valid' => true,
                'type' => $discount->getRawOriginal('type')
            ];
        } catch (Exception $e) {
            Log::error("Discount application failed", [
                'code' => $discountCode,
                'amount' => $originalAmount,
                'error' => $e->getMessage()
            ]);

            return [
                'original' => $originalAmount,
                'discount' => 0,
                'final' => $originalAmount,
                'valid' => false
            ];
        }
    }
}

if (!function_exists('discountPercentCalculation')) {
    function discountPercentCalculation($amount, $discount_amount)
    {
        if ($amount <= 0 || $discount_amount <= 0) {
            return 0;
        }

        $percent = ($discount_amount / ($amount + $discount_amount)) * 100;

        return round($percent, 1);
    }
}

if (!function_exists('generateCode')) {
    function generateCode(): string
    {
        return str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+[]{}|;:,.<>?';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = random_int(0, $charactersLength - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}

if (!function_exists('existUser')) {
    function existUser(string $field, string $value)
    {
        $user = User::where($field, $value)->first();

        if ($user) {
            return true;
        }
        return false;
    }
}

function canUserSubmitService($user)
{
    return getRemainingServiceQuota($user) > 0;
}

function incrementServiceUsage($user)
{
    $usages = UserSubscriptionUsage::where('user_id', $user->id)
        ->where('used', false)
        ->with('userSubscription.subscription')
        ->orderBy('created_at')
        ->get();

    foreach ($usages as $usage) {
        $subscription = $usage->userSubscription->subscription ?? null;
        if (!$subscription) continue;

        $limit = $subscription->service_limit ?? 0;

        if ($usage->used_services < $limit) {
            $usage->used_services += 1;

            if ($usage->used_services >= $limit) {
                $usage->used = true;
            }

            $usage->save();

            return;
        }
    }

    throw new \Exception('No available service quota left.');
}



function getRemainingServiceQuota($user)
{
    $usages = UserSubscriptionUsage::where('user_id', $user->id)
        ->where('used', false)
        ->with('userSubscription.subscription')
        ->get();

    $totalRemaining = 0;

    foreach ($usages as $usage) {
        $subscription = $usage->userSubscription->subscription ?? null;
        if (!$subscription) continue;

        $limit = $subscription->service_limit ?? 0;
        $used = $usage->used_services;

        $totalRemaining += max(0, $limit - $used);
    }

    return $totalRemaining;
}


function getUnreadCount($fromUserId, $toUserId)
{
    return Message::whereHas('conversation', function ($q) use ($fromUserId, $toUserId) {
        $q->where(function ($q2) use ($fromUserId, $toUserId) {
            $q2->where('user_id', $fromUserId)->where('advisor_id', $toUserId);
        })->orWhere(function ($q2) use ($fromUserId, $toUserId) {
            $q2->where('user_id', $toUserId)->where('advisor_id', $fromUserId);
        });
    })
        ->where('sender_id', $fromUserId)
        ->where('seen', 0)
        ->count();
}


function standardizeSlug(string $str): string
{
    $str = trim($str);
    // هر کاراکتر غیر از حروف، اعداد، فضا و - را حذف کن
    $str = preg_replace('/[^\p{L}\p{N}\s\-]+/u', '', $str);
    // فضاها و خط تیره‌های پیاپی را به یک - تبدیل کن
    $str = preg_replace('/[\s\-]+/u', '-', $str);
    // - اضافی ابتدا/انتها را بردار
    return trim($str, '-');
}


function text_limit($text, $limit = 100, $end = '...')
{
    return Str::limit(strip_tags($text), $limit, $end);
}


// دریافت ماشین‌های VIP
// $vipCars = getCars('vip', null, 4);
// دریافت ماشین‌های مشابه
// $relativeCars = getCars('relative', 'پراید');
// دریافت جدیدترین ماشین‌ها
// $newCars = getCars('new');
// استفاده با تعداد مشخص
// $latestCars = getCars('new', null, 5);
function getCars($type, $brandId = null, $limit = 10)
{
    $query = Car::with(['brand', 'attributeValues.attribute']);

    switch ($type) {
        case 'relative':
            if ($brandId) {
                $query->where('brand_id', $brandId);
            }
            break;

        case 'vip':
            $query->where('vip', true);
            break;

        case 'new':
            $query->orderBy('created_at', 'desc');
            break;
    }

    $cars = $query->take($limit)->get();

    return CarResource::collection($cars)->resolve();
}


function getBrands()
{
    $brands = Brand::get();

    $brands->map(function ($brand) {
        $brand->url = url('/cars?filter[brand][]=' . $brand->slug);
        return $brand;
    });

    return $brands;
}
