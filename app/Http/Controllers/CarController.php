<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Attribute;
use App\Models\CarAttributeValue;
use App\Models\CarFile;
use App\Models\Brand;
use App\Models\CarFileItem;
use App\Models\CarFileItemValue;
use App\Models\CarFileRating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:car-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:car-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:car-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:car-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cars = Car::with('attributeValues.attribute', 'attributeValues.attributeValue')->latest()->paginate(15);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        $users = User::with('document')->role('advisor')->get();
        $attributes = collect(); // Empty collection, will be loaded dynamically based on brand selection
        $fileItems = CarFileItem::with('carFile')->get();
        $carFiles = CarFile::get();
        $brands = Brand::get();
        $models = [];

        return view('admin.cars.create', compact('attributes', 'fileItems', 'carFiles', 'brands', 'models', 'users'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string',
            'slug'  => 'required|unique:cars,slug',
            'thumbnail' => 'nullable|string',
            'gallery'     => 'nullable|string',
            'certificate'     => 'nullable|string',
            'description' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'user_id' => 'required|exists:users,id',
            'car_model_id' => 'required|exists:car_models,id',
        ]);

        DB::transaction(function () use ($request) {
            // ایجاد ماشین جدید
            $car = Car::create([
                'title' => $request->title,
                'slug'  => standardizeSlug($request->slug),
                'thumbnail' => $request->thumbnail ?? null,
                'gallery' => $request->gallery ?? null,
                'certificate' => $request->certificate ?? null,
                'description' => $request->description ?? null,
                'status' => $request->status,
                'vip' => $request->vip,
                'keyword' => $request->has('keyword'),
                'brand_id' => $request->brand_id,
                'user_id' => $request->user_id,
                'car_model_id' => $request->car_model_id,
            ]);

            // ذخیره ویژگی‌ها
            foreach ($request->car_attributes ?? [] as $attrData) {
                if (empty($attrData['attribute_id'])) continue;

                $attribute = Attribute::find($attrData['attribute_id']);
                if (!$attribute) continue;

                $carAttr = [
                    'car_id' => $car->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => null,
                    'value_string' => null,
                    'value_number' => null,
                    'value_boolean' => null,
                    'value_boolean_label' => null,
                ];

                switch ($attribute->type) {
                    case 'select':
                        $carAttr['attribute_value_id'] = $attrData['value'] ?? null;
                        break;

                    case 'boolean':
                        $carAttr['value_boolean'] = isset($attrData['value']) ? (bool)$attrData['value'] : null;
                        $carAttr['value_boolean_label'] = $attrData['value_boolean_label'] ?? $attribute->value_boolean_label;
                        break;

                    case 'number':
                    case 'range':
                        $carAttr['value_number'] = isset($attrData['value']) ? (int)$attrData['value'] : null;
                        break;

                    default: // string
                        $carAttr['value_string'] = $attrData['value'] ?? null;
                        break;
                }
                CarAttributeValue::create($carAttr);
            }


            // ذخیره وضعیت آیتم‌های فایل
            foreach ($request->car_file_items ?? [] as $itemId => $data) {
                if (empty($data['status'])) continue;

                CarFileItemValue::create([
                    'car_id' => $car->id,
                    'car_file_item_id' => $itemId,
                    'status' => $data['status'],
                    'status_description' => $data['status_description'] ?? null,
                ]);
            }

            if ($request->has('file_ratings')) {
                foreach ($request->file_ratings as $carFileId => $rating) {
                    if (!empty($rating)) {
                        CarFileRating::create([
                            'car_file_id' => $carFileId,
                            'car_id' => $car->id,
                            'rating' => $rating,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('cars.index')->with('success', 'ماشین با موفقیت ایجاد شد');
    }

    public function edit(Car $car)
    {
        $users = User::with('document')->role('advisor')->get();
        $attributes = collect(); // Empty collection, will be loaded dynamically based on brand selection
        $carFiles = CarFile::with('items')->get();
        $brands = Brand::get();

        $models = $car->brand ? $car->brand->carModels : [];

        $car->load('attributeValues.attribute', 'attributeValues.attributeValue', 'fileItemValues', 'fileRatings');
        return view('admin.cars.edit', compact('car', 'attributes', 'carFiles', 'brands', 'models', 'users'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'title' => 'required|string',
            'slug'  => 'required|unique:cars,slug,' . $car->id,
            'thumbnail' => 'nullable|string',
            'gallery'     => 'nullable|string',
            'certificate'     => 'nullable|string',
            'description' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'user_id' => 'required|exists:users,id',
            'car_model_id' => 'required|exists:car_models,id',
        ]);

        DB::transaction(function () use ($request, $car) {
            // بروزرسانی ماشین
            $car->update([
                'title' => $request->title,
                'slug'  => standardizeSlug($request->slug), // استفاده از تابع standardizeSlug مانند متد store
                'thumbnail' => $request->thumbnail ?? null,
                'gallery' => str_replace('&quot;', '"', $request->gallery) ?? null, // اضافه کردن فیلد gallery که در متد store وجود داشت
                'certificate' => $request->certificate ?? null,
                'description' => $request->description ?? null,
                'status' => $request->status,
                'vip' => $request->vip,
                'keyword' => $request->has('keyword'),
                'brand_id' => $request->brand_id,
                'user_id' => $request->user_id,
                'car_model_id' => $request->car_model_id,
            ]);

            // حذف مقادیر قبلی ویژگی‌ها
            $car->attributeValues()->delete();

            // ذخیره مجدد ویژگی‌ها با همان الگوی متد store
            foreach ($request->car_attributes ?? [] as $attrData) {
                if (empty($attrData['attribute_id'])) continue;

                $attribute = Attribute::find($attrData['attribute_id']);
                if (!$attribute) continue;

                $carAttr = [
                    'car_id' => $car->id,
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => null,
                    'value_string' => null,
                    'value_number' => null,
                    'value_boolean' => null,
                    'value_boolean_label' => null,
                ];

                switch ($attribute->type) {
                    case 'select':
                        $carAttr['attribute_value_id'] = $attrData['value'] ?? null;
                        break;

                    case 'boolean':
                        $carAttr['value_boolean'] = isset($attrData['value']) ? (bool)$attrData['value'] : null;
                        $carAttr['value_boolean_label'] = $attrData['value_boolean_label'] ?? $attribute->value_boolean_label;
                        break;

                    case 'number':
                    case 'range':
                        $carAttr['value_number'] = isset($attrData['value']) ? (int)$attrData['value'] : null;
                        break;

                    default: // string
                        $carAttr['value_string'] = $attrData['value'] ?? null;
                        break;
                }
                CarAttributeValue::create($carAttr);
            }

            // حذف مقادیر قبلی آیتم‌های فایل
            $car->fileItemValues()->delete();

            // ذخیره مجدد آیتم‌های فایل با همان الگوی متد store
            foreach ($request->car_file_items ?? [] as $itemId => $data) {
                if (empty($data['status'])) continue;

                CarFileItemValue::create([
                    'car_id' => $car->id,
                    'car_file_item_id' => $itemId,
                    'status' => $data['status'],
                    'status_description' => $data['status_description'] ?? null,
                ]);
            }


            // مدیریت امتیاز پرونده‌ها
            $car->fileRatings()->delete(); // حذف امتیازهای قبلی

            if ($request->has('file_ratings')) {
                foreach ($request->file_ratings as $carFileId => $rating) {
                    if (!empty($rating)) {
                        CarFileRating::create([
                            'car_file_id' => $carFileId,
                            'car_id' => $car->id,
                            'rating' => $rating,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('cars.index')->with('success', 'ماشین با موفقیت ویرایش شد');
    }

    public function destroy(Car $car)
    {
        DB::transaction(function () use ($car) {

            $car->attributeValues()->delete();

            $car->fileItemValues()->delete();

            $car->delete();
        });

        return redirect()->route('cars.index')->with('success', 'ماشین با موفقیت حذف شد');
    }

    public function getModelsByBrand(Brand $brand)
    {
        $models = $brand->carModels;
        return response()->json($models);
    }
}
