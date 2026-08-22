<?php

namespace App\Models;

use App\Enums\DeviceType;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable(['user_id', 'fcm_token', 'device_type'])]
class UserDeviceToken extends BaseModel
{
    protected $casts = [
        'device_type' => DeviceType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->dontLogIfAttributesChangedOnly(['*']);
    }
}
