<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name', 'site_description', 'default_og_image', 'contact_email',
        'github_url', 'linkedin_url', 'fiverr_url', 'upwork_url',
    ];

    public static function current(): self
    {
        return self::query()->firstOrCreate(['id' => 1], [
            'site_name' => config('app.name'),
        ]);
    }
}
