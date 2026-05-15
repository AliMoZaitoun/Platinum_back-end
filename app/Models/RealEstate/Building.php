<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['project_id', 'location_id', 'building_number', 'description', 'floors_count', 'status'])]
class Building extends Model
{
    use HasTranslations;
    public $translatable = ['description'];

    protected function casts(): array
    {
        return [
            'description' => 'array',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function getLocationAttribute($value)
    {
        return $value ?? $this->project->location;
    }
}
