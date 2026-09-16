<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutomationLog extends Model
{
    protected $fillable = [
        'run_at', 'slot', 'category', 'topic', 'blog_post_id', 'blog_url', 'word_count',
        'linkedin_attempted', 'linkedin_posted', 'linkedin_post_url', 'status', 'error_message',
    ];

    protected $casts = [
        'run_at' => 'datetime',
        'linkedin_attempted' => 'boolean',
        'linkedin_posted' => 'boolean',
    ];
}
