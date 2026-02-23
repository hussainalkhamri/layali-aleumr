<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SystemInsight extends Model
{
    use HasUuids;
    protected $fillable = [
        'title',
        'content',
        'level',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
