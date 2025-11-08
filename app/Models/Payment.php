<?php

namespace App\Models;

use App\Traits\GeneratesInvoiceNumber;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUuids, GeneratesInvoiceNumber;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_subscription_id',
        'type',
        'amount',
        'discount_amount',
        'discount_code',
        'transaction_id',
        'invoice_number',
        'authority',
        'description',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }

    public function walletTransaction()
    {
        return $this->hasOne(WalletTransaction::class);
    }
}
