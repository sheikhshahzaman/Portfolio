<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'icon',
        'order',
    ];

    protected $casts = [
        'proficiency' => 'integer',
    ];

    public function translations()
    {
        return $this->hasMany(SkillTranslation::class);
    }

    public function translation($languageId)
    {
        return $this->translations()->where('language_id', $languageId)->first();
    }
}
