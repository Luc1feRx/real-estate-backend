<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Scope: chỉ cấp 1
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }
}
