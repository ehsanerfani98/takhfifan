<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::latest()->paginate(10);
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        return view('admin.subscriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required',
            'name' => 'required|max:100',
            'price' => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'service_limit' => 'required|integer|min:1',
        ]);

        Subscription::create([
            'icon' => $request->icon,
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'service_limit' => $request->service_limit,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'اشتراک با موفقیت ایجاد شد.');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);

        $query = UserSubscription::with(['subscription', 'payment'])
            ->where('user_id', $user->id)
            ->latest('starts_at');

        $rawSubscriptions = $query->paginate(20);

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

        $sorted = $subscriptions->sortByDesc(function ($item) {
            return $item->status === 'active' ? 1 : 0;
        })->values();

        $paginated = new LengthAwarePaginator(
            $sorted,
            $rawSubscriptions->total(),
            $rawSubscriptions->perPage(),
            $rawSubscriptions->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.users.subscriptions.show', [
            'subscriptions' => $paginated
        ]);
    }


    public function edit(Subscription $subscription)
    {
        return view('admin.subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $request->validate([
            'icon' => 'required',
            'name' => 'required|max:100',
            'price' => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'service_limit' => 'required|integer|min:1',
        ]);

        $subscription->update([
            'icon' => $request->icon,
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'service_limit' => $request->service_limit,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'اشتراک با موفقیت ویرایش شد.');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('success', 'اشتراک حذف شد.');
    }
}
