<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarFileItem;
use App\Models\CarFileItemValue;
use Illuminate\Http\Request;

class CarFileItemValueController extends Controller
{
    public function edit(Car $car)
    {
        // بارگذاری آیتم‌ها و مقادیر مرتبط با ماشین
        $files = CarFileItem::with(['values' => fn($q) => $q->where('car_id', $car->id)])->get();
        return view('admin.car_file_item_values.edit', compact('car', 'files'));
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->input('items', []);

        foreach ($data as $itemId => $itemData) {
            CarFileItemValue::updateOrCreate(
                ['car_id' => $car->id, 'car_file_item_id' => $itemId],
                [
                    'status' => $itemData['status'] ?? null,
                    'status_description' => $itemData['status_description'] ?? null,
                ]
            );
        }

        return redirect()->route('cars.edit', $car->id)->with('success', 'مقادیر پرونده‌ها ذخیره شد.');
    }
}
