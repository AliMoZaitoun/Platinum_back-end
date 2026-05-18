<?php

namespace App\Models\RealEstate;

use App\Models\Engineer\Attendance;
use App\Models\Engineer\EngineerProject;
use App\Models\Engineer\ProjectEngineerAllocation;
use App\Models\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'description', 'location_id', 'latitude', 'longitude', 'radius_meters', 'status', 'start_date', 'end_date'])]
class Project extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
            'radius_meters' => 'integer',
        ];
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function engineers()
    {
        return $this->hasMany(ProjectEngineerAllocation::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
