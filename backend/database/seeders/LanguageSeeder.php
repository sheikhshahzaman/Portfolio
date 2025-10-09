<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'is_default' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'code' => 'es',
                'name' => 'Spanish',
                'native_name' => 'Español',
                'is_default' => false,
                'is_active' => false,
                'order' => 2,
            ],
            [
                'code' => 'fr',
                'name' => 'French',
                'native_name' => 'Français',
                'is_default' => false,
                'is_active' => false,
                'order' => 3,
            ],
            [
                'code' => 'de',
                'name' => 'German',
                'native_name' => 'Deutsch',
                'is_default' => false,
                'is_active' => false,
                'order' => 4,
            ],
            [
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'العربية',
                'is_default' => false,
                'is_active' => false,
                'order' => 5,
            ],
        ];

        foreach ($languages as $language) {
            \App\Models\Language::create($language);
        }
    }
}
