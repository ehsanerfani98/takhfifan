<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
   public function index()
    {
        $discounts = Discount::orderby('id', 'desc')->get();
        return view('admin.discount.index', compact(['discounts']));
    }

    public function create()
    {
        $users = User::with('document')->orderby('id', 'desc')->get();
        return view('admin.discount.create', compact(['users']));
    }

    public function store(Request $request)
    {
        $discount = new Discount();
        $discount->create($request->all());
        return back()->with('success', 'کد تخفیف با موفقیت ایجاد شد');
    }

    public function edit(Discount $discount)
    {
        $users = User::orderby('id', 'desc')->get();
        return view('admin.discount.edit', compact(['discount', 'users']));
    }

    public function update(Request $request, Discount $discount)
    {
        $discount->update($request->all());
        return back()->with('success', 'کد تخفیف با موفقیت بروزرسانی شد');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return back()->with('success', 'کد تخفیف با موفقیت حذف شد');
    }
}
