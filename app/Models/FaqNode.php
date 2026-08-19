<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FaqNode extends Model
{
    use HasTranslations;

    protected $fillable = [
        'parent_id',
        'title',
        'content',
        'type',
        'sort_order'
    ];

    protected $casts = [
        'title'   => 'array',
        'content' => 'array',
    ];

    public $translatable = ['title', 'content'];

    public function children()
    {
        return $this->hasMany(FaqNode::class, 'parent_id')->orderBy('sort_order');
    }

    public function parent()
    {
        return $this->belongsTo(FaqNode::class, 'parent_id');
    }
}
