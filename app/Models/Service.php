<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'description', 'price_from',
        'rating', 'rating_count', 'image_url', 'fiverr_url',
        'featured', 'sort_order',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'price_from' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(ServicePackage::class)->orderBy('sort_order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(ServiceFaq::class)->orderBy('sort_order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
