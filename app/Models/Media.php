<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

class Media extends Model
{

    protected function casts(): array
    {
        return [
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
}
