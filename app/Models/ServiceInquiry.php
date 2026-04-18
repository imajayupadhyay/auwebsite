<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceInquiry extends Model
{
    protected $fillable = [
        'service', 'name', 'email', 'phone', 'company',
        'budget', 'timeline', 'details', 'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
