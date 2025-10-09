<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationKey extends Model
{
    protected $fillable = [
        'key',
        'language_id',
        'value',
        'group',
        'description',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public static function getTranslations($languageCode = 'en')
    {
        $language = Language::where('code', $languageCode)->first();

        if (!$language) {
            $language = Language::where('is_default', true)->first();
        }

        return static::where('language_id', $language->id)
            ->get()
            ->groupBy('group')
            ->map(function ($items) {
                // Strip the group prefix from the key (e.g., "nav.home" becomes "home")
                $result = [];
                foreach ($items as $item) {
                    // Extract the key name after the last dot
                    $keyParts = explode('.', $item->key);
                    $keyName = end($keyParts);
                    $result[$keyName] = $item->value;
                }
                return $result;
            });
    }
}
