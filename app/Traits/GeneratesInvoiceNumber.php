<?php

namespace App\Traits;

use Morilog\Jalali\Jalalian;

trait GeneratesInvoiceNumber
{
    public static function bootGeneratesInvoiceNumber()
    {
        static::creating(function ($model) {
            $model->invoice_number = $model->generateInvoiceNumber();
        });
    }

    public function generateInvoiceNumber(): int
    {
        // تاریخ شمسی: 1404/06/12 ← خروجی: 140406
        $prefix = Jalalian::fromCarbon(now())->format('Ymd'); // حتماً با Ymd بزرگ
        $base = (int)($prefix . '000');

        $lastNumber = static::where('invoice_number', '>=', $base)
            ->where('invoice_number', '<', $base + 1000)
            ->max('invoice_number');

        return $lastNumber ? $lastNumber + 1 : $base + 1;
    }
}
