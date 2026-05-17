<?php

namespace App\Models\Marketing;

use App\Models\Core\Employee;
use App\Models\Media;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description', 'starts_at', 'ends_at', 'duration_days', 'status', 'created_by'])]
class Advertisement extends Model
{
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at'   => 'datetime',
            'status'    => 'boolean',
        ];
    }

    public function created_by()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function scopeActive($query)
    {
        $now = now();
        return $query->where('status', 1)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now);
    }

    public function attachments()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
