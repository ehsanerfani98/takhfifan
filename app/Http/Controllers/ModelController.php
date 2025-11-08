<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModelController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:car-model-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:car-model-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:car-model-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:car-model-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $carModels = CarModel::where('brand_id', $request->brand_id)->with('brand')->latest()->paginate(10);
        return view('admin.car-models.index', compact('carModels'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.car-models.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug'  => 'required|unique:car_models,slug',
            'brand_id' => 'required|exists:brands,id',
            'years' => 'nullable|array',
            'types' => 'nullable|array',
            'colors' => 'nullable|array',
        ]);

        CarModel::create([
            'title' => $request->title,
            'slug'  => standardizeSlug($request->slug),
            'brand_id' => $request->brand_id,
            'years' => $request->years,
            'types' => $request->types,
            'colors' => $request->colors,
        ]);

        return redirect()->route('models.index', ['brand_id' => $request->brand_id])
            ->with('success', 'مدل خودرو با موفقیت ایجاد شد.');
    }

    public function edit(CarModel $Model)
    {
        $brands = Brand::all();
        return view('admin.car-models.edit', compact('Model', 'brands'));
    }

    public function update(Request $request, CarModel $Model)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug'  => 'required|unique:brands,slug,' . $Model->id,
            'brand_id' => 'required|exists:brands,id',
            'years' => 'nullable|array',
            'types' => 'nullable|array',
            'colors' => 'nullable|array',
        ]);

        $Model->update([
            'title' => $request->title,
            'slug'  => standardizeSlug($request->slug),
            'brand_id' => $request->brand_id,
            'years' => $request->years,
            'types' => $request->types,
            'colors' => $request->colors,
        ]);
        return redirect()->route('models.index', ['brand_id' => $request->brand_id])
            ->with('success', 'مدل خودرو با موفقیت ویرایش شد.');
    }

    public function destroy(CarModel $Model)
    {
        $Model->delete();
        return redirect()->back()->with('success', 'مدل خودرو با موفقیت حذف شد.');
    }

    public function getByBrand($brand_id)
    {
        $models = CarModel::where('brand_id', $brand_id)->get(['id', 'title', 'slug', 'years', 'types', 'colors']);
        return response()->json($models);
    }

    public function getAllCarModels()
    {
        $models = CarModel::all(['id', 'title', 'slug']);
        return response()->json($models);
    }
}