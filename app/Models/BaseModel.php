<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class BaseModel extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        $attributes = array_keys($this->getAttributes());

        return LogOptions::defaults()
            ->logOnly($attributes)
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
