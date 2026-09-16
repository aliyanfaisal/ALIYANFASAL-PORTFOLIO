<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedInToken extends Model
{
    protected $fillable = [
        'access_token', 'refresh_token', 'expires_at', 'member_urn',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Get the single stored token row, or null if LinkedIn has never been connected.
     */
    public static function current(): ?self
    {
        return self::query()->find(1);
    }

    /**
     * Create or update the single token row (id=1) with the given attributes.
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function store(array $attributes): self
    {
        $token = self::query()->findOrNew(1);
        $token->fill($attributes);
        $token->id = 1;
        $token->save();

        return $token;
    }
}
