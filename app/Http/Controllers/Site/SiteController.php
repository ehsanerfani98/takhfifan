<?php

namespace App\Http\Controllers\Site;

use App\Facades\ZarinPal;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\UserSubscriptionUsage;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{

    public function subscript_plans(Request $request)
    {
        $status_payment = $request->has('status_payment') && $request->status_payment == 'upgrade' ? true : false;
        $subscriptions = Subscription::where('is_active', 1)->get();
        return view('site.subscript_plans', compact(['subscriptions', 'status_payment']));
    }

    public function select_subscription(Request $request, $subscription_id)
    {
        $status_payment = $request->has('status_payment') && $request->status_payment == true ? true : false;

        if (!$status_payment) {
            if (auth()->user()->hasActiveSubscription()) {
                return redirect()->back()->with('error', 'شما یک اشتراک فعال دارید');
            }
        }

        if ($status_payment) {
            $newSubscription = Subscription::findOrFail($subscription_id);

            $activeSubscription = getCurrentSubscript();

            if (!$activeSubscription) {
                return redirect()->back()->with('error', 'هیچ اشتراک فعالی برای ارتقا یافت نشد');
            }

            // if ($activeSubscription->subscription->duration_days >= $newSubscription->duration_days) {
            //     return redirect()->back()->with('error', 'این اشتراک قبلا خریداری شده است');
            // }
        }

        return view('site.payment_type', compact(['subscription_id', 'status_payment']));
    }

    public function payment_subscription(Request $request)
    {
        $user = auth()->user();
        $status_payment = filter_var($request->status_payment, FILTER_VALIDATE_BOOLEAN);

        if (!$status_payment && $user->hasActiveSubscription()) {
            return redirect()->route('user.doc.register')->with('error', 'شما یک اشتراک فعال دارید');
        }

        $subscription = Subscription::findOrFail($request->subscription_id);

        $discount = !empty($request->discount_code)
            ? applyDiscount($subscription->price, $request->discount_code)
            : ['valid' => true, 'final' => $subscription->price, 'discount' => 0];

        if (!$discount['valid']) {
            return redirect()->route('user.subscript.plans')->with('error', 'کد تخفیف معتبر نیست!');
        }

        $price = $discount['final'];
        $discount_price = $discount['discount'];
        $description = ($status_payment ? 'ارتقا' : 'خرید') . ' اشتراک عضویت / ' . $subscription->name;

        if ($request->gateway === 'zarinpal') {
            $payment = Payment::create([
                'user_id' => $user->id,
                'type' => 'subscription_direct',
                'amount' => $price,
                'discount_amount' => $discount_price,
                'discount_code' => !empty($request->discount_code) ? $request->discount_code : null,
                'status' => 'pending',
                'description' => $description,
            ]);

            $callback = route('user.subscript.payment.verify', [
                'subscription_id' => $subscription->id,
                'payment_id' => $payment->id,
                'status_payment' => $status_payment
            ]);

            $result = ZarinPal::request($price, $callback, $description, '', $user->phone, get_setting('payment_gateway_unit'));

            if ($result['success']) {
                $payment->update(['authority' => $result['authority']]);
                return redirect($result['paymentUrl']);
            }

            return 'Error: ' . $result['error']['message'];
        }

        if ($request->gateway === 'wallet') {
            $payment = Payment::create([
                'user_id' => $user->id,
                'type' => 'subscription_wallet',
                'amount' => $price,
                'discount_amount' => $discount_price,
                'discount_code' => !empty($request->discount_code) ? $request->discount_code : null,
                'status' => 'pending',
                'description' => $description,
            ]);

            if (!useWallet($price, $description, $payment)) {
                return redirect()->route('user.doc.register')->with('success', 'موجودی کیف پول کافی نیست');
            }

            $payment->update(['status' => 'paid']);

            if ($status_payment) {
                $remainingDays = remainingDays();
                $payment->update(['description' => $description . ' + ' . $remainingDays . ' روز اشتراک قبلی ']);
                $this->upgrade_subscript($subscription->id, $payment, $remainingDays);
            } else {
                $userSub = UserSubscription::create([
                    'user_id' => $user->id,
                    'subscription_id' => $subscription->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addDays($subscription->duration_days),
                ]);
                $payment->update(['user_subscription_id' => $userSub->id]);
            }

            if ($discount_price) {
                trackDiscountUsage($discount_price);
            }

            return redirect()->route('user.doc.register')->with('success', 'پرداخت با موفقیت انجام شد');
        }
    }

    public function payment_verify_subscription(Request $request)
    {
        $status_payment = filter_var($request->status_payment, FILTER_VALIDATE_BOOLEAN);
        $payment = Payment::find($request->payment_id);
        $subscription = Subscription::findOrFail($request->subscription_id);
        $authority = $request->input('Authority');
        $status = $request->input('Status');

        $discount = $payment->discount_amount > 0
            ? applyDiscount($subscription->price, $payment->discount_code)
            : ['valid' => true, 'final' => $subscription->price, 'discount' => 0];


        $price = $discount['final'];

        if ($status !== 'OK') {
            $payment?->update(['status' => 'failed']);
            return redirect()->route('user.doc.register')->with('error', 'پرداخت انجام نشد');
        }


        $result = ZarinPal::verify($authority, $price);

        if (!$result['success']) {
            $payment?->update(['status' => 'failed']);
            return redirect()->route('user.doc.register')->with('error', 'پرداخت ناموفق بود. لطفاً مجدداً تلاش کنید. ' . $result['error']['message']);
        }

        if (!$payment || $payment->status !== 'pending') {
            return redirect()->route('user.doc.register')->with('error', 'وضعیت پرداخت نامعتبر است');
        }

        return DB::transaction(function () use ($payment, $subscription, $result, $status_payment) {
            $payment->update([
                'status' => 'paid',
                'transaction_id' => $result['referenceId'],
            ]);

            if ($status_payment) {
                $remainingDays = remainingDays();
                $desc = 'ارتقا اشتراک عضویت / ' . $subscription->name . ' + ' . $remainingDays . ' روز اشتراک قبلی ';
                $payment->update(['description' => $desc]);
                $this->upgrade_subscript($subscription->id, $payment, $remainingDays);
                if ($payment->discount_amount > 0)
                    trackDiscountUsage($payment->discount_code);
                return redirect()->route('user.doc.register')->with('success', 'ارتقای اشتراک با موفقیت انجام شد');
            }

            $userSub = UserSubscription::create([
                'user_id' => $payment->user_id,
                'subscription_id' => $subscription->id,
                'starts_at' => now(),
                'ends_at' => now()->addDays($subscription->duration_days),
            ]);

            UserSubscriptionUsage::firstOrCreate([
                'user_id' => $payment->user_id,
                'user_subscription_id' => $userSub->id,
            ]);

            $payment->update(['user_subscription_id' => $userSub->id]);
            if ($payment->discount_amount > 0)
                trackDiscountUsage($payment->discount_code);
            return redirect()->route('user.doc.register')->with('success', 'پرداخت با موفقیت انجام شد');
        });
    }

    public function upgrade_subscript($subscription_id, $payment, $remainingDays)
    {
        $user = auth()->user();
        $newSubscription = Subscription::findOrFail($subscription_id);

        getCurrentSubscript()->update(['ends_at' => now()]);

        $userSubscription = UserSubscription::create([
            'user_id' => $user->id,
            'subscription_id' => $newSubscription->id,
            'starts_at' => now(),
            'ends_at' => now()->addDays($newSubscription->duration_days + $remainingDays),
        ]);

        UserSubscriptionUsage::firstOrCreate([
            'user_id' => $payment->user_id,
            'user_subscription_id' => $userSubscription->id,
        ]);

        $payment->update(['user_subscription_id' => $userSubscription->id]);
        return true;
    }

    // public function payment_subscription(Request $request)
    // {
    //     $status_payment = $request->has('status_payment') && $request->status_payment == true ? true : false;

    //     if (!$status_payment) {
    //         if (auth()->user()->hasActiveSubscription()) {
    //             return redirect()->route('user.doc.register')->with('error', 'شما یک اشتراک فعال دارید');
    //         }
    //     }

    //     $subscription = Subscription::findOrFail($request->subscription_id);

    //     if (!empty($request->discount_code)) {
    //         $discount = applyDiscount($subscription->price, $request->discount_code);
    //         if (!$discount['valid']) {
    //             return redirect()->route('user.subscript.plans')->with('error', 'کد تخفیف معتبر نیست!');
    //         }
    //         $price = $discount['final'];
    //         $discount_price = $discount['discount'];
    //     } else {
    //         $price = $subscription->price;
    //         $discount_price = 0;
    //     }

    //     if ($request->gateway == 'zarinpal') {

    //         $payment = Payment::create([
    //             'user_id' => auth()->id(),
    //             'type' => 'subscription_direct',
    //             'amount' => $price,
    //             'discount_amount' => $discount_price,
    //             'status' => 'pending',
    //             'description' => $status_payment ? 'ارتقا اشتراک عضویت / ' . $subscription->name : 'خرید اشتراک عضویت / ' . $subscription->name,
    //         ]);

    //         $result = ZarinPal::request(
    //             $price,
    //             route('user.subscript.payment.verify', ['subscription_id' => $subscription->id, 'payment_id' => $payment->id, 'status_payment' => $status_payment]),
    //             $status_payment ? 'ارتقا اشتراک عضویت / ' . $subscription->name : 'خرید اشتراک عضویت / ' . $subscription->name,
    //             '',
    //             auth()->user()->phone,
    //             get_setting('payment_gateway_unit')
    //         );

    //         if ($result['success']) {
    //             $payment->authority = $result['authority'];
    //             $payment->save();
    //             return redirect($result['paymentUrl']);
    //         } else {
    //             return 'Error: ' . $result['error']['message'];
    //         }
    //     } elseif ($request->gateway == 'wallet') {
    //         $payment = Payment::create([
    //             'user_id' => auth()->id(),
    //             'type' => 'subscription_wallet',
    //             'amount' => $price,
    //             'discount_amount' => $discount_price,
    //             'status' => 'pending',
    //             'description' => $status_payment ? 'ارتقا اشتراک عضویت / ' . $subscription->name : 'خرید اشتراک عضویت / ' . $subscription->name,
    //         ]);
    //         $status_wallet = useWallet($price, $status_payment ? 'ارتقا اشتراک عضویت / ' . $subscription->name : 'خرید اشتراک عضویت / ' . $subscription->name, $payment);
    //         if ($status_wallet) {
    //             if ($status_payment) {
    //                 $remainingDays = remainingDays();
    //                 $payment->update(['status' => 'paid', 'description' => 'ارتقا اشتراک عضویت / ' . $subscription->name . ' + ' . $remainingDays . ' روز اشتراک قبلی ']);
    //                 $this->upgrade_subscript($subscription->id, $payment, $remainingDays);
    //                 if (!empty($payment->discount_amount)) {
    //                     trackDiscountUsage($payment->discount_amount);
    //                 }
    //                 return redirect()->route('user.doc.register')->with('success', 'پرداخت با موفقیت انجام شد');
    //             } else {
    //                 $payment->update(['status' => 'paid']);
    //                 $userSub = UserSubscription::create([
    //                     'user_id' => $payment->user_id,
    //                     'subscription_id' => $subscription->id,
    //                     'starts_at' => now(),
    //                     'ends_at' => now()->addDays($subscription->duration_days),
    //                 ]);
    //                 $payment->update(['user_subscription_id' => $userSub->id]);
    //                 if (!empty($payment->discount_amount)) {
    //                     trackDiscountUsage($payment->discount_amount);
    //                 }
    //                 return redirect()->route('user.doc.register')->with('success', 'پرداخت با موفقیت انجام شد');
    //             }
    //         } else {
    //             return redirect()->route('user.doc.register')->with('success', 'موجودی کیف پول کافی نیست');
    //         }
    //     }
    // }

    //  public function payment_verify_subscription(Request $request)
    // {

    //     $status_payment = $request->has('status_payment') && $request->status_payment == true ? true : false;

    //     $payment = Payment::where('id', $request->payment_id)->first();
    //     $authority = $request->input('Authority');
    //     $status = $request->input('Status');

    //     if ($status !== 'OK') {
    //         $payment->update(['status' => 'failed']);
    //         return redirect()->route('user.doc.register')->with('error', 'پرداخت انجام نشد');
    //     }

    //     $subscription = Subscription::findOrFail($request->subscription_id);

    //     $result = ZarinPal::verify($authority, $subscription->price);

    //     if ($result['success']) {

    //         $referenceId = $result['referenceId'];

    //         if ($payment && $payment->status === 'pending') {
    //             $redirect = DB::transaction(function () use ($payment, $subscription, $referenceId, $status_payment) {
    //                 if ($status_payment) {
    //                     $remainingDays = remainingDays();
    //                     $payment->update(['status' => 'paid', 'transaction_id' => $referenceId, 'description' => 'ارتقا اشتراک عضویت / ' . $subscription->name . ' + ' . $remainingDays . ' روز اشتراک قبلی ']);
    //                     $this->upgrade_subscript($subscription->id, $payment, $remainingDays);
    //                     if (!empty($payment->discount_amount)) {
    //                         trackDiscountUsage($payment->discount_amount);
    //                     }
    //                     return redirect()->route('user.doc.register')->with('success', 'ارتقای اشتراک با موفقیت انجام شد');
    //                 } else {
    //                     $payment->update(['status' => 'paid', 'transaction_id' => $referenceId]);
    //                     $userSub = UserSubscription::create([
    //                         'user_id' => $payment->user_id,
    //                         'subscription_id' => $subscription->id,
    //                         'starts_at' => now(),
    //                         'ends_at' => now()->addDays($subscription->duration_days),
    //                     ]);
    //                     $payment->update(['user_subscription_id' => $userSub->id]);
    //                     if (!empty($payment->discount_amount)) {
    //                         trackDiscountUsage($payment->discount_amount);
    //                     }
    //                     return redirect()->route('user.doc.register')->with('success', 'پرداخت با موفقیت انجام شد');
    //                 }
    //             });
    //             return $redirect;
    //         }
    //     } else {
    //         $payment->update(['status' => 'failed']);
    //         return redirect()->route('user.doc.register')->with('error', 'پرداخت ناموفق بود. لطفاً مجدداً تلاش کنید.' . $result['error']['message']);
    //     }
    // }

    // public function upgrade_subscript($subscription_id, $payment, $remainingDays)
    // {

    //     $user = auth()->user();
    //     $newSubscription = Subscription::findOrFail($subscription_id);

    //     // انقضای اشتراک فعلی
    //     getCurrentSubscript()->update([
    //         'ends_at' => now(),
    //     ]);

    //     $totalDays = $newSubscription->duration_days + $remainingDays;
    //     $startsAt = now();
    //     $endsAt = (clone $startsAt)->addDays($totalDays);

    //     $userSubscription = UserSubscription::create([
    //         'user_id' => $user->id,
    //         'subscription_id' => $newSubscription->id,
    //         'starts_at' => $startsAt,
    //         'ends_at' => $endsAt,
    //     ]);

    //     $payment->update(['user_subscription_id' => $userSubscription->id]);

    //     return true;
    // }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->with('author')->firstOrFail();
        return view('site.page', compact('page'));
    }

}
