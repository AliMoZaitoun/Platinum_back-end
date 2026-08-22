<?php

namespace App\Models;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'uuid',
    'mediable_id',
    'mediable_type',
    'path',
    'original_name',
    'type',
    'custom_properties',
    'recorded_at'
])]

class Media extends BaseModel
{

    protected function casts(): array
    {
        return [
            'type'              => MediaType::class,
            'custom_properties' => 'array',
            'recorded_at'       => 'datetime',
        ];
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->path ? Storage::disk(config('filesystems.default', 's3'))->url($this->path) : null,
        );
    }

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->dontLogIfAttributesChangedOnly(['*']);
    }
}
