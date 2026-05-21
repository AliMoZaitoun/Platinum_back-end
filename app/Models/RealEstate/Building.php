<?php

namespace App\Models\RealEstate;

use App\Models\Engineer\Attendance;
use App\Models\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['project_id', 'location_id', 'building_number', 'latitude', 'longitude', 'radius_meters', 'description', 'floors_count', 'status'])]
class Building extends Model
{
    use HasTranslations;
    public $translatable = ['description'];

    protected function casts(): array
    {
        return [
            'description' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
            'radius_meters' => 'integer'
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

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
