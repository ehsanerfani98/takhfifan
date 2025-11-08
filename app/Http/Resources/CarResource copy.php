<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description,

            // attributes مرتب شده بر اساس sort_order
            'attributes' => $this->attributeValues
                ->sortBy(fn ($item) => $item->attribute->sort_order) // مرتب‌سازی
                ->map(function ($item) {
                    $value = $item->attributeValue
                        ? $item->attributeValue->value
                        : ($item->value_number ?? $item->value_string ?? $item->value_boolean);

                    // اگر نوع attribute رنج است
                    if ($item->attribute->type === 'range') {
                        $value = $item->value_number; // فقط یک عدد
                    }

                    // اگر نوع attribute بولین باشد
                    if ($item->attribute->type === 'boolean') {
                        $labels = explode(',', $item->value_boolean_label); // ["بله", "خیر"]
                        $yesLabel = $labels[0] ?? 'بله';
                        $noLabel  = $labels[1] ?? 'خیر';

                        $value = $item->value_boolean ? $yesLabel : $noLabel;
                    }

                    // اگر نام فیلتر price است و مقدار عددی است
                    if ($item->attribute->name === 'price' && is_numeric($value)) {
                        if (is_array($value)) {
                            $value = [
                                number_format($value[0]),
                                number_format($value[1]),
                            ];
                        } else {
                            $value = number_format($value) . ' تومان ';
                        }
                    }

                    return [
                        'attribute' => [
                            'id'    => $item->attribute->id,
                            'slug'  => $item->attribute->slug,
                            'name'  => $item->attribute->name,
                            'label' => $item->attribute->label,
                            'type'  => $item->attribute->type,
                        ],
                        'value' => $value,
                    ];
                })
                ->values(), // ایندکس‌ها از 0 مرتب میشن
        ];
    }
}
