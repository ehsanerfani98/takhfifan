<?php

namespace App\Http\Controllers;

use App\Models\CarRequest;
use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carRequests = CarRequest::with(['user'])->paginate(10);
        return view('admin.car_requests.index', compact('carRequests'));
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
    public function show(CarRequest $carRequest)
    {
        $carRequest->load(['user']);
        return view('admin.car_requests.show', compact('carRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarRequest $carRequest)
    {
        return view('admin.car_requests.edit', compact('carRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CarRequest $carRequest)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'nullable|exists:cars,id',
            'status' => 'required|in:در حال بررسی,تایید شد,رد شد,انجام شد',
        ]);

        $carRequest->update($validated);

        return redirect()->route('car-requests.index')
            ->with('success', 'درخواست ماشین با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarRequest $carRequest)
    {
        $carRequest->delete();

        return redirect()->route('car-requests.index')
            ->with('success', 'درخواست ماشین با موفقیت حذف شد.');
    }

    public function save_sell_request(Request $request)
    {
        $data = $request->except('_token');
        $car_request = new CarRequest();
        $car_request->user_id = Auth::id();
        $car_request->type = $request->request_type;
        $car_request->data = $data;
        $car_request->save();
    }

    public function save_buy_request(Request $request)
    {
        $data = $request->except('_token');
        $car_request = new CarRequest();
        $car_request->user_id = Auth::id();
        $car_request->car_id = $request->car_id;
        $car_request->type = $request->request_type;
        $car_request->save();
    }
}
