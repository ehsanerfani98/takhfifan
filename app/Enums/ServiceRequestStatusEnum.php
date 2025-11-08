<?php

namespace App\Enums;

enum ServiceRequestStatusEnum: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'در حال بررسی',
            self::IN_PROGRESS => 'در حال انجام',
            self::APPROVED => 'تایید شده',
            self::REJECTED => 'رد شده',
            self::COMPLETED => 'تکمیل شده',
            self::CANCELLED => 'لغو شده',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'info',
            self::IN_PROGRESS => 'primary',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
            self::COMPLETED => 'secondary',
            self::CANCELLED => 'warning',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'bi-clock-fill',
            self::IN_PROGRESS => 'bi-arrow-repeat',
            self::APPROVED => 'bi-check-circle-fill',
            self::REJECTED => 'bi-x-circle-fill',
            self::COMPLETED => 'bi-check-all',
            self::CANCELLED => 'bi-slash-circle',
        };
    }
}