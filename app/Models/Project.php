<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'categories',
        'external_url', 'featured', 'sort_order',
    ];

    protected $casts = [
        'categories' => 'array',
        'featured' => 'boolean',
    ];
}
