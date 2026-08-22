<?php

namespace App\Models;

use App\Models\Core\Employee;
use App\Models\Engineer\Engineer;
use App\Models\RealEstate\Building;
use App\Models\BaseModel;
use App\Models\RealEstate\Unit;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'uuid',
    'employee_id',
    'building_id',
    'unit_id',
    'user_prompt',
    'design_style',
    'generated_image_urls',
])]

class ApartmentDesignSuggestion extends BaseModel
{
    use HasFactory;

    protected $casts = [
        'generated_image_urls' => 'array',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
