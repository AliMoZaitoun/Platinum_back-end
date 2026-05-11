<?php

namespace App\Models\RealEstate;

use App\Models\Engineer\EngineerProject;
use App\Models\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'location_id', 'latitude', 'longitude', 'radius_meters', 'status', 'start_date', 'end_date'])]
class Project extends Model
{
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
        return $this->hasMany(EngineerProject::class);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
