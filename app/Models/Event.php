<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Event extends Model
{
    protected $fillable = [
        "contact_id",
        "type_id",
        "user_id",
        "title",
        "notes",
        "send_date",
        "remind_at",
        "status"
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(EventType::class, 'type_id');
    }

    public function setSendDateAttribute($value)
    {
        if (is_string($value) && preg_match('/^\d{4}\/\d{2}\/\d{2} \d{2}:\d{2}$/', $value)) {
            $this->attributes['send_date'] = Jalalian::fromFormat('Y/m/d H:i', $value)->toCarbon();
        } else {
            $this->attributes['send_date'] = $value;
        }
    }

    public function setRemindAtAttribute($value)
    {
        if (is_string($value) && preg_match('/^\d{4}\/\d{2}\/\d{2} \d{2}:\d{2}$/', $value)) {
            $this->attributes['remind_at'] = Jalalian::fromFormat('Y/m/d H:i', $value)->toCarbon();
        } else {
            $this->attributes['remind_at'] = $value;
        }
    }
}
