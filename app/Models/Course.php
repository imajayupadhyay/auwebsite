<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    protected $fillable = [
        'code', 'slug', 'title', 'subtitle', 'icon', 'dot_color',
        'level', 'language', 'hours', 'price', 'original_price',
        'rating', 'students', 'available', 'last_updated_text',
        'description', 'tags', 'outcomes', 'requirements', 'sort_order',
    ];

    protected $casts = [
        'tags'           => 'array',
        'outcomes'       => 'array',
        'requirements'   => 'array',
        'available'      => 'boolean',
        'rating'         => 'decimal:2',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_course');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class)->orderBy('sort_order');
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(CourseLesson::class, CourseModule::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('available', true);
    }
}
