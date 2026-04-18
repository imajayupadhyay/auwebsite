<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLesson extends Model
{
    protected $fillable = ['module_id', 'title', 'duration', 'drive_file_id', 'is_preview', 'sort_order'];

    protected $casts = [
        'is_preview' => 'boolean',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function getDrivePreviewUrlAttribute(): ?string
    {
        return $this->drive_file_id
            ? "https://drive.google.com/file/d/{$this->drive_file_id}/preview"
            : null;
    }
}
