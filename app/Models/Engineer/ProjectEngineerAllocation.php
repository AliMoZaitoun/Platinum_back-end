<?php

namespace App\Models\Engineer;

use App\Models\RealEstate\Building;
use App\Models\RealEstate\Project;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['engineer_id', 'project_id', 'building_id', 'start_date', 'end_date'])]
class ProjectEngineerAllocation extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }
}
