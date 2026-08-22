<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable(['user_id', 'device_name', 'token', 'expires_at'])]
class RefreshToken extends BaseModel
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->dontLogIfAttributesChangedOnly(['*']);
    }
}
