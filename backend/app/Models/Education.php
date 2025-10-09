<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'degree',
        'institution',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'type',
        'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(EducationTranslation::class);
    }

    public function translation($languageId)
    {
        return $this->translations()->where('language_id', $languageId)->first();
    }
}
