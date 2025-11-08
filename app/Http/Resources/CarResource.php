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
        $statusIcon = 'fas fa-question-circle';
        $statusColor = '#999';
        $statusLabel = 'نامشخص';

        switch ($this->status) {
            case 'assessed':
                $statusIcon = 'fas fa-check-circle';
                $bgColor = 'rgba(16, 185, 129, 0.12)';
                $statusColor = '#10b981';
                $statusLabel = 'کارشناسی شده';
                break;

            case 'inreview':
                $statusIcon = 'fas fa-clock';
                $bgColor = '#ffab1c17';
                $statusColor = '#ffab1c';
                $statusLabel = 'در حال کارشناسی';
                break;

            case 'sold':
                $statusIcon = 'fas fa-times-circle';
                $bgColor = '#e74c3c14';
                $statusColor = '#e74c3c';
                $statusLabel = 'فروخته شد';
                break;
        }

        return [
            'id'          => $this->id,
            'image'       => $this->thumbnail ?? asset('images/notcarimage.jpg'),
            'title'       => $this->title,
            'url'        => route('car', $this->slug),
            'description' => $this->description,
            'status' => [
                "statusIcon" => $statusIcon,
                "bgColor" => $bgColor,
                "statusColor" => $statusColor,
                "statusLabel" => $statusLabel
            ],
            // فیلدهای مستقیم بر اساس scopeValueOf
            'kilometer'   => $this->attributeValues()->valueOf('kilometer'),
            'gearbox'     => $this->attributeValues()->valueOf('gearbox'),
            'price'       => $this->attributeValues()->valueOf('price'),
            'year'       => $this->attributeValues()->valueOf('year'),

            // همچنان attributes کامل هم برای انعطاف
            'attributes' => $this->attributeValues
                ->sortBy(fn ($item) => $item->attribute->sort_order)
                ->map(function ($item) {
                    $value = $item->attributeValue
                        ? $item->attributeValue->value
                        : ($item->value_number ?? $item->value_string ?? $item->value_boolean);

                    if ($item->attribute->type === 'range') {
                        $value = $item->value_number;
                    }

                    if ($item->attribute->type === 'boolean') {
                        $labels = explode(',', $item->value_boolean_label);
                        $yesLabel = $labels[0] ?? 'بله';
                        $noLabel  = $labels[1] ?? 'خیر';

                        $value = $item->value_boolean ? $yesLabel : $noLabel;
                    }

                    if ($item->attribute->slug === 'price' && is_numeric($value)) {
                        $value = number_format($value) . ' تومان ';
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
                ->values(),
        ];
    }
}
