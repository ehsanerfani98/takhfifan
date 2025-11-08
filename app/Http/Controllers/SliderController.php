<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->paginate(10);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'image' => 'required|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Slider::create($validated);

        return redirect()->route('sliders.index')->with('success', 'اسلاید با موفقیت ایجاد شد.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url',
            'order' => 'nullable|integer',
            'image' => 'nullable|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $slider->update($validated);

        return redirect()->route('sliders.index')->with('success', 'اسلاید با موفقیت بروزرسانی شد.');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('sliders.index')->with('success', 'اسلاید حذف شد.');
    }

}