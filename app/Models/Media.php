<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['mediable_id', 'mediable_type', 'file_path', 'original_name', 'file_type', 'custom_properties'])]

class Media extends Model
{
    public function mediable()
    {
        return $this->morphTo();
    }
}
