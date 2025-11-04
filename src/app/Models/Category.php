<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    const ACTIVE = 1;
    const INACTIVE = 0;
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

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
