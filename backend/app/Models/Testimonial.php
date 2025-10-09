<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'client_name',
        'client_position',
        'client_company',
        'content',
        'avatar',
        'rating',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'rating' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        $url = $this->getFirstMediaUrl('avatar');

        // If URL is relative, prepend the APP_URL
        if ($url && !str_starts_with($url, 'http')) {
            return config('app.url') . $url;
        }

        return $url;
    }

    public function translations()
    {
        return $this->hasMany(TestimonialTranslation::class);
    }

    public function translation($languageId)
    {
        return $this->translations()->where('language_id', $languageId)->first();
    }
}
