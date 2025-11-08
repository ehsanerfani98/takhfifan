<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
