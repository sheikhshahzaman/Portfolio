<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BlogPost extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'tags',
        'category',
        'is_published',
        'published_at',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'twitter_card',
        'canonical_url',
        'robots',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        $url = $this->getFirstMediaUrl('featured');

        // If URL is relative, prepend the APP_URL
        if ($url && !str_starts_with($url, 'http')) {
            return config('app.url') . $url;
        }

        return $url;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
