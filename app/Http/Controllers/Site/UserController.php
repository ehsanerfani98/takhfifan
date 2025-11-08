<?php

namespace App\Http\Controllers\Site;

use App\Facades\ZarinPal;
use App\Http\Controllers\Controller;
use App\Models\DocumentFile;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function home()
    {
        return view('site.home');
    }

    public function edit_profile()
    {
        $user = Auth::user();
        return view('site.profile', compact(['user']));
    }

    public function buy_service($id)
    {
        $service = Service::findOrFail($id);
        return view('site.buy_service', compact(['service']));
    }

    public function child_service($id)
    {
        $services = Service::with(['children' => function ($query) {
            $query->where('is_active', 1);
        }])->findOrFail($id);
        return view('site.child_services', compact(['services']));
    }

    public function doc_register()
    {
        $user = Auth::user()->load('document', 'document.files');
        $files = $user->document ? $user->document->files : collect();
        return view('site.document_register', compact(['user', 'files']));
    }

    public function store_docs(Request $request)
    {
        $user = auth()->user()->load('document');

        if (boolval(optional($user->document)->is_verified)) {
            return redirect()->back()->with('error', 'مدارک شما تایید شده است و امکان ویرایش وجود ندارد!');
        }

        $validated = $request->validate([
            'uploaded_files' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'mobile' => 'nullable|numeric',
            'company_name' => 'nullable|string',
            'national_id' => 'nullable|numeric',
            'company_address' => 'nullable|string',
            'type' => 'required|in:real,legal',
        ]);

        $uploadedPaths = json_decode($request->input('uploaded_files'), true) ?? [];

        DB::transaction(function () use ($request, $uploadedPaths, $user) {
            $doc = UserDocument::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'type' => $request->input('type'),
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'mobile' => $request->input('mobile'),
                    'company_name' => $request->input('company_name'),
                    'national_id' => $request->input('national_id'),
                    'company_address' => $request->input('company_address'),
                    'is_verified' => 0,
                    'needs_correction' => 0,
                ]
            );

            foreach ($uploadedPaths as $tempPath) {
                // اصلاح 1: بررسی وجود مسیر و اینکه واقعاً یک فایل است نه دایرکتوری
                if (!File::exists(public_path($tempPath)) || is_dir(public_path($tempPath))) {
                    continue;
                }

                // اصلاح 2: ساخت مسیر مقصد
                $destinationFolder = public_path('uploads/documents');
                if (!File::exists($destinationFolder)) {
                    File::makeDirectory($destinationFolder, 0755, true);
                }

                // اصلاح 3: استخراج نام فایل از مسیر موقت
                $fileName = basename($tempPath);
                $newPath = $destinationFolder . '/' . $fileName;

                // اصلاح 4: جابجایی فایل
                try {
                    File::move(public_path($tempPath), $newPath);

                    DocumentFile::create([
                        'user_document_id' => $doc->id,
                        'path' => 'uploads/documents/' . $fileName, // مسیر نسبی برای ذخیره در دیتابیس
                        'original_name' => pathinfo($tempPath, PATHINFO_FILENAME) // حفظ نام اصلی
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error moving file: ' . $e->getMessage());
                    continue;
                }
            }
        });

        if (auth()->user()->hasActiveSubscription()) {
            return redirect()->back()->with('success', 'اطلاعات با موفقیت ثبت شد');
        } else {
            return redirect()->route('user.subscript.plans');
        }
    }

    public function user_transactions()
    {
        $user = auth()->user();
        $payments = $user->payments()->latest()->paginate(2);
        return view('site.user_transactions', compact(['payments']));
    }

    public function user_subscriptions()
    {
        $user = Auth::user();

        // دریافت همه اشتراک‌های کاربر به همراه پلن و پرداخت
        $query = UserSubscription::with(['subscription', 'payment'])
            ->where('user_id', $user->id)
            ->latest('starts_at');

        $rawSubscriptions = $query->paginate(2);

        // تبدیل و محاسبه وضعیت اشتراک
        $subscriptions = $rawSubscriptions->getCollection()->map(function ($item) {
            $status = 'expired';
            if ($item->ends_at > now()) {
                $status = 'active';
            }

            return (object) [
                'plan_title' => $item->subscription->name ?? '---',
                'start_date' => $item->starts_at,
                'end_date' => $item->ends_at,
                'created_at' => $item->created_at,
                'duration_days' => $item->subscription->duration_days . ' روز',
                'remaining_time' => $item->ends_at > now()
                    ? now()->diff($item->ends_at)->format('%a روز و %h ساعت')
                    : 'به اتمام رسید',
                'status' => $status,
            ];
        });

        // ✅ مرتب‌سازی: اشتراک فعال اول، بعد اشتراک‌های منقضی
        $sorted = $subscriptions->sortByDesc(function ($item) {
            return $item->status === 'active' ? 1 : 0;
        })->values(); // values() برای ری‌ست ایندکس‌ها

        // صفحه‌بندی مجدد پس از مرتب‌سازی
        $paginated = new LengthAwarePaginator(
            $sorted,
            $rawSubscriptions->total(),
            $rawSubscriptions->perPage(),
            $rawSubscriptions->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('site.user_subscriptions', [
            'subscriptions' => $paginated
        ]);
    }

    public function user_profile_details()
    {
        $user = User::with(['document.files'])->findOrFail(auth()->id());

        return view('site.profile_details', compact('user'));
    }

    public function user_wallet()
    {
        $user = auth()->user();

        $wallet = $user->wallet;

        if (!$wallet) {
            $transactions = collect();
        } else {
            $transactions = $wallet->transactions()
                ->latest()
                ->paginate(2);
        }

        return view('site.user_wallet', compact('transactions'));
    }

    public function user_wallet_payment(Request $request)
    {

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'type' => 'wallet_topup',
            'amount' => $request->amount,
            'status' => 'pending',
            'description' => 'شارژ کیف پول',
        ]);

        $result = ZarinPal::request(
            $request->amount,
            route('user.wallet.payment.verify', ['payment_id' => $payment->id]),
            'شارژ کیف پول',
            '',
            auth()->user()->phone,
            get_setting('payment_gateway_unit')
        );
        if ($result['success']) {
            $payment->authority = $result['authority'];
            $payment->save();
            return redirect($result['paymentUrl']);
        } else {
            return 'Error: ' . $result['error']['message'];
        }
    }

    public function user_wallet_payment_verify(Request $request)
    {

        $payment = Payment::where('id', $request->payment_id)->first();
        $authority = $request->input('Authority');
        $status = $request->input('Status');

        if ($status !== 'OK') {
            $payment->update(['status' => 'failed']);
            return redirect()->route('user.doc.register')->with('error', 'پرداخت انجام نشد');
        }

        $result = ZarinPal::verify($authority, $payment->amount);

        if ($result['success']) {

            $referenceId = $result['referenceId'];

            if ($payment && $payment->status === 'pending') {
                $redirect = DB::transaction(function () use ($payment, $referenceId) {
                    $payment->update(['status' => 'paid', 'transaction_id' => $referenceId]);
                    chargeWallet($payment);
                    return redirect()->route('user.doc.register')->with('success', 'پرداخت با موفقیت انجام شد');
                });
                return $redirect;
            }
        } else {
            $payment->update(['status' => 'failed']);
            return redirect()->route('user.doc.register')->with('error', 'پرداخت ناموفق بود. لطفاً مجدداً تلاش کنید.' . $result['error']['message']);
        }
    }

    public function factor($tid)
    {
        $info = Payment::where('id', $tid)->with('user.document', 'subscription')->first();
        if ($info->status != 'paid') {
            return redirect()->back()->with('error', 'برای این تراکنش فاکتور صادر نمیگردد!');
        }
        if ($info->user->document) {
            return view('site.factor', compact(['info']));
        } else {
            return redirect()->back()->with('error', 'برای دریافت فاکتور ابتدا باید اطلاعات خود را کامل کنید.');
        }
    }

    public function user_requests()
    {
        $serviceRequests = ServiceRequest::with(['service'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('site.requests', [
            'serviceRequests' => $serviceRequests
        ]);
    }
}
