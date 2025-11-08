<?php

// app/Models/ServiceRequest.php

namespace App\Models;

use App\Enums\ServiceRequestStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'service_id',
        'status',
        'description',
        'admin_notes',
        'rejection_reason',
        'completed_at',
    ];

    protected $casts = [
        'status' => ServiceRequestStatusEnum::class,
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // دسترسی به برچسب وضعیت
    public function getStatusLabelAttribute()
    {
        return $this->status->label();
    }

    // اسکوپ برای فیلتر بر اساس وضعیت
    public function scopePending($query)
    {
        return $query->where('status', ServiceRequestStatusEnum::PENDING->value);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', ServiceRequestStatusEnum::APPROVED->value);
    }

    // و سایر اسکوپ‌های مورد نیاز...
}