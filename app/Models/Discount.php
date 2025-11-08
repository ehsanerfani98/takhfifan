<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Discount extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'user_ids',
        'code',
        'amount',
        'percent',
        'type',
        'expiration',
        'status',
        'access',
        'limitdiscount',
    ];

    public function getStatusAttribute($status)
    {
        switch ($status) {
            case 'disable':
                $status = '<span class="label label-danger">غیرفعال</span>';
                break;
            case 'enable':
                $status = '<span class="label label-success">فعال</span>';
                break;
            default:
                break;
        }
        return $status;
    }

    public function getTypeAttribute($type)
    {
        switch ($type) {
            case 'percent':
                $type = '<span class="label label-info">درصد</span>';
                break;
            case 'amount':
                $type = '<span class="label label-info">مبلغ</span>';
                break;
            default:
                break;
        }
        return $type;
    }

    public function setUserIdsAttribute($value)
    {
        $this->attributes['user_ids'] = serialize($value);
    }

    public function getUserIdsAttribute($value)
    {
        return unserialize($value);
    }

    public function setExpirationAttribute($value)
    {
        if (is_string($value) && preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $value)) {
            $this->attributes['expiration'] = Jalalian::fromFormat('Y/m/d', $value)->toCarbon();
        } else {
            $this->attributes['expiration'] = $value;
        }
    }
}