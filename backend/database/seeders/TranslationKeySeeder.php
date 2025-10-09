<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\TranslationKey;

class TranslationKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the English language
        $englishLang = Language::where('code', 'en')->first();

        if (!$englishLang) {
            $this->command->error('English language not found. Please run LanguageSeeder first.');
            return;
        }

        // Define all translation keys grouped by section
        $translations = [
            'nav' => [
                'home' => 'Home',
                'projects' => 'Projects',
                'experience' => 'Experience',
                'skills' => 'Skills',
                'blog' => 'Blog',
                'resume' => 'Resume',
                'contact' => 'Contact',
            ],
            'hero' => [
                'greeting' => 'Hi, my name is',
                'view_work' => 'View My Work',
                'download_resume' => 'Download Resume',
                'get_in_touch' => 'Get In Touch',
            ],
            'projects' => [
                'featured_projects' => 'Featured Projects',
                'all_projects' => 'All Projects',
                'explore_text' => 'Explore my portfolio of web applications and platforms',
                'live_demo' => 'Live Demo →',
                'github' => 'GitHub →',
                'view_details' => 'View Details →',
                'featured_badge' => 'Featured',
                'technologies_used' => 'Technologies Used',
                'view_live_demo' => 'View Live Demo →',
                'view_github' => 'View on GitHub →',
                'back_to_projects' => '← Back to Projects',
                'project_not_found' => 'Project Not Found',
            ],
            'experience' => [
                'title' => 'Work Experience',
                'present' => 'Present',
            ],
            'skills' => [
                'title' => 'Skills & Expertise',
            ],
            'testimonials' => [
                'title' => 'Testimonials',
                'at_separator' => ' at ',
            ],
            'contact' => [
                'title' => 'Get In Touch',
                'name_label' => 'Name',
                'email_label' => 'Email',
                'subject_label' => 'Subject',
                'message_label' => 'Message',
                'send_button' => 'Send Message',
                'sending' => 'Sending...',
                'error_default' => 'Failed to send message. Please try again.',
            ],
            'blog' => [
                'title' => 'Blog',
                'subtitle' => 'Thoughts on web development, technology, and more',
                'views' => 'views',
                'read_more' => 'Read More →',
                'no_posts' => 'No blog posts yet. Check back soon!',
                'back_to_blog' => '← Back to Blog',
                'post_not_found' => 'Post Not Found',
            ],
        ];

        // Insert all translation keys for English
        $this->command->info('Creating translation keys for English...');

        foreach ($translations as $group => $keys) {
            foreach ($keys as $key => $value) {
                TranslationKey::updateOrCreate(
                    [
                        'key' => "{$group}.{$key}",
                        'language_id' => $englishLang->id,
                    ],
                    [
                        'value' => $value,
                        'group' => $group,
                        'description' => "Translation for {$group}.{$key}",
                    ]
                );
            }
        }

        $this->command->info('Translation keys created successfully!');

        // Get all other active languages and create empty translation keys for them
        $otherLanguages = Language::where('id', '!=', $englishLang->id)
            ->where('is_active', true)
            ->get();

        if ($otherLanguages->count() > 0) {
            $this->command->info('Creating translation key templates for other languages...');

            foreach ($otherLanguages as $language) {
                foreach ($translations as $group => $keys) {
                    foreach ($keys as $key => $value) {
                        TranslationKey::updateOrCreate(
                            [
                                'key' => "{$group}.{$key}",
                                'language_id' => $language->id,
                            ],
                            [
                                'value' => $value, // Start with English value as placeholder
                                'group' => $group,
                                'description' => "Translation for {$group}.{$key}",
                            ]
                        );
                    }
                }
                $this->command->info("Created translation keys for {$language->name}");
            }
        }

        $this->command->info('All translation keys created!');
    }
}
