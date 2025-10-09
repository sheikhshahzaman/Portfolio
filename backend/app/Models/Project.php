<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected static function booted()
    {
        static::saved(function ($project) {
            $project->syncTranslationKeys();
        });

        static::deleted(function ($project) {
            $project->deleteTranslationKeys();
        });
    }

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
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function translations()
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    public function translation($languageId)
    {
        return $this->translations()->where('language_id', $languageId)->first();
    }

    /**
     * Sync project data with translation keys
     */
    public function syncTranslationKeys()
    {
        $defaultLanguage = Language::where('is_default', true)->first();
        if (!$defaultLanguage) {
            return;
        }

        $group = 'projects';
        $prefix = "project.{$this->id}";

        $keysToSync = [
            "{$prefix}.title" => $this->title,
            "{$prefix}.short_description" => $this->short_description,
            "{$prefix}.description" => $this->description,
            "{$prefix}.category" => $this->category,
        ];

        foreach ($keysToSync as $key => $value) {
            TranslationKey::updateOrCreate(
                [
                    'key' => $key,
                    'language_id' => $defaultLanguage->id,
                ],
                [
                    'value' => $value ?? '',
                    'group' => $group,
                    'description' => "Translation for {$key}",
                ]
            );
        }

        // Sync translations for other languages
        foreach ($this->translations as $translation) {
            $translationKeysToSync = [
                "{$prefix}.title" => $translation->title,
                "{$prefix}.short_description" => $translation->short_description,
                "{$prefix}.description" => $translation->description,
                "{$prefix}.category" => $translation->category,
            ];

            foreach ($translationKeysToSync as $key => $value) {
                if (!empty($value)) {
                    TranslationKey::updateOrCreate(
                        [
                            'key' => $key,
                            'language_id' => $translation->language_id,
                        ],
                        [
                            'value' => $value,
                            'group' => $group,
                            'description' => "Translation for {$key}",
                        ]
                    );
                }
            }
        }
    }

    /**
     * Delete translation keys when project is deleted
     */
    public function deleteTranslationKeys()
    {
        $prefix = "project.{$this->id}";
        TranslationKey::where('key', 'like', "{$prefix}.%")->delete();
    }
}
