<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'category',
        'technologies',
        'demo_url',
        'github_url',
        'featured_image',
        'is_featured',
        'is_published',
        'order',
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
