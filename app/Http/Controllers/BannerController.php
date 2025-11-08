<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'thumbnail' => 'required|max:2048',
            'cover' => 'required|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Banner::create($validated);

        return redirect()->route('banners.index')->with('success', 'بنر با موفقیت ایجاد شد.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $Banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'thumbnail' => 'nullable|max:2048',
            'cover' => 'nullable|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $Banner->update($validated);

        return redirect()->route('banners.index')->with('success', 'بنر با موفقیت بروزرسانی شد.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'بنر حذف شد.');
    }

}