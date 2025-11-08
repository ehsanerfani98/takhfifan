<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:brand-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:brand-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:brand-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:brand-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $brands = Brand::withCount('carModels')->latest()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        $attributes = Attribute::where('is_active', true)->get(['id', 'name', 'label', 'type']);
        return view('admin.brands.create', compact('attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:brands,title',
            'slug'  => 'required|unique:brands,slug',
            'icon' => 'nullable|string|max:255',
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:attributes,id',
        ]);

        $brand = Brand::create([
            'title' => $request->title,
            'icon' => $request->icon,
            'slug'  => standardizeSlug($request->slug),
        ]);

        if ($request->has('attributes')) {
            $attributes = array_filter($request->input('attributes'), function($value) {
                return !empty($value) && is_numeric($value);
            });
            $brand->attributes()->sync($attributes);
        }

        return redirect()->route('brands.index')
            ->with('success', 'برند با موفقیت ایجاد شد.');
    }

    public function edit(Brand $brand)
    {
        $attributes = Attribute::where('is_active', true)->get(['id', 'name', 'label', 'type']);
        $brand->load('attributes');
        return view('admin.brands.edit', compact('brand', 'attributes'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:brands,title,' . $brand->id,
            'slug'  => 'required|unique:brands,slug,' . $brand->id,
            'icon'  => 'nullable|string|max:255',
            'attributes' => 'nullable|array',
            'attributes.*' => 'exists:attributes,id',
        ]);

        $brand->update([
            'title' => $request->title,
            'icon'  => $request->icon,
            'slug'  => standardizeSlug($request->slug),
        ]);

        if ($request->has('attributes')) {
            $attributes = array_filter($request->input('attributes'), function($value) {
                return !empty($value) && is_numeric($value);
            });
            $brand->attributes()->sync($attributes);
        } else {
            $brand->attributes()->detach();
        }

        return redirect()->route('brands.index')
            ->with('success', 'برند با موفقیت ویرایش شد.');
    }


    public function destroy(Brand $brand)
    {
        if ($brand->carModels()->count() > 0) {
            return redirect()->route('brands.index')
                ->with('error', 'امکان حذف برند وجود ندارد زیرا مدل‌هایی دارد.');
        }

        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'برند با موفقیت حذف شد.');
    }

    public function getAllBrands()
    {
        $brands = Brand::all(['id', 'title', 'icon', 'slug']);
        return response()->json($brands);
    }

    public function getBrandAttributes(Brand $brand)
    {
        $attributes = $brand->attributes()
            ->where('is_active', true)
            ->with(['values'])
            ->orderBy('brand_attributes.sort_order')
            ->get(['attributes.id', 'attributes.name', 'attributes.label', 'attributes.slug', 'attributes.type', 'attributes.is_multiple', 'attributes.format_thousands']);

        return response()->json($attributes);
    }
}
