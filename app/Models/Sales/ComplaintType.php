<?php

namespace App\Models\Sales;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

#[Fillable(['title', 'created_by'])]
class ComplaintType extends Model
{
    use HasTranslations, SoftDeletes;

    protected function casts(): array
    {
        return [
            'title' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'complaint_type_id');
    }
}
