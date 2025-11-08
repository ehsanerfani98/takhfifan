<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarFile;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $popularSearches = [
            'کیا سراتو',
            'سانتافه',
            'سراتو مونتاژ',
            'هیوندای توسان',
            'کیا اسپورتیج'
        ];
        return view('site.home', compact('popularSearches'));
    }
    public function cars()
    {
        // return view('car_deatils');
        return view('site.cars');
    }
    public function car_single($slug)
    {
        // اول ماشین رو بگیر و relation های لازم رو eager load کن
        $car = Car::where('slug', $slug)
            ->with([
                'attributeValues.attribute',    // attribute relation لازم است
                'attributeValues.attributeValue',
                'brand',
                'car_model',
                'fileRatings',
                'user.document'
            ])
            ->firstOrFail();

        // فیلتر و مرتب‌سازی attributeValues بر اساس attribute (is_active & show_in_card & sort_order)
        $visibleAttrs = $car->attributeValues
            ->filter(function ($av) {
                return $av->attribute
                    && $av->attribute->is_active
                    && $av->attribute->show_in_card;
            })
            ->sortBy(fn($av) => $av->attribute->sort_order ?? 0)
            ->values();

        // جایگزین کردن relation با مجموعه فیلتر شده (تا در Blade مستقیم استفاده بشه)
        $car->setRelation('attributeValues', $visibleAttrs);
        // دریافت مقدار به صورت تک

        $info_cars = [
            'price' => $car->attributeValues()->valueOf('price'),
            'year' => $car->attributeValues()->valueOf('year'),
            'color' => $car->attributeValues()->valueOf('color'),
            'kilometer' => $car->attributeValues()->valueOf('kilometer'),
            'gearbox' => $car->attributeValues()->valueOf('gearbox')
        ];

        // پرونده‌ها به همراه آیتم‌ها و مقادیر مربوط به این ماشین
        $carFiles = CarFile::with([
            'items.values' => function ($query) use ($car) {
                $query->where('car_id', $car->id);
            },
            'items' // مطمئن می‌شویم items هم لود شده
        ])->get();


        return view('site.car_single', compact('car', 'carFiles', 'info_cars'));
    }

    public function carsell(){
        return view('site.carsell');
    }

    public function carbuy(){
        return view('site.carbuy');
    }
    public function carinspection(){
        return view('site.carinspection');
    }

}
