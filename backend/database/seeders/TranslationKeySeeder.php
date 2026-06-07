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

        // Define all translation keys grouped by section (Solstice design)
        $translations = [
            'nav' => [
                'home' => 'Home',
                'projects' => 'Projects',
                'about' => 'About',
                'experience' => 'Experience',
                'skills' => 'Skills',
                'services' => 'Services',
                'blog' => 'Blog',
                'resume' => 'Resume',
                'contact' => 'Contact',
                'lets_talk' => "Let's talk",
            ],
            'hero' => [
                'greeting' => 'Hi, my name is',
                'lede' => 'Five years building backends and the full stack around them. I architect systems that stay calm under real traffic. 1M+ users shipped.',
                'view_work' => 'View my work',
                'get_in_touch' => 'Get in touch',
                'download_resume' => 'Download Resume',
            ],
            'projects' => [
                'featured_projects' => 'Featured Projects',
                'heading_a' => 'Some of my',
                'heading_b' => 'recent work.',
                'subtitle' => 'Real systems in production. Keep scrolling to slide through them.',
                'view_details' => 'View details',
                'featured_badge' => 'Project',
                'page_eyebrow' => 'Selected Work',
                'page_heading_a' => 'Things I have',
                'page_heading_b' => 'shipped.',
                'page_subtitle' => 'Real systems where the architecture was the point. The problem, what I built, and what it moved.',
                'empty' => 'No projects yet. Check back soon.',
                'live_demo_label' => 'Live demo',
                'github_label' => 'View on GitHub',
                'back_to_projects' => '← Back to Projects',
                'project_not_found' => 'Project Not Found',
                'not_found_sub' => 'That project may have moved or been unpublished.',
            ],
            'experience' => [
                'eyebrow' => 'Work Experience',
                'heading_a' => 'My professional',
                'heading_b' => 'journey.',
                'subtitle' => 'Where I have worked and what I shipped there.',
                'present' => 'Present',
            ],
            'education' => [
                'eyebrow' => 'Education',
                'heading_a' => 'Background &',
                'heading_b' => 'certifications.',
                'subtitle' => 'Where the foundations came from.',
                'present' => 'Present',
            ],
            'skills' => [
                'eyebrow' => 'Skills',
                'heading_a' => 'Technologies I',
                'heading_b' => 'work with.',
                'subtitle' => 'The tools I reach for, and how deep I go.',
            ],
            'testimonials' => [
                'eyebrow' => 'Testimonials',
                'heading_a' => 'What clients',
                'heading_b' => 'say.',
                'subtitle' => 'A few words from people I have built for.',
                'at_separator' => ' · ',
            ],
            'cta' => [
                'eyebrow' => 'Contact',
                'heading_a' => "Let's build something that",
                'heading_b' => 'scales.',
                'subtitle' => 'Hiring, a hard systems problem, or just comparing notes on architecture. I read everything.',
                'primary' => 'Start a conversation',
                'secondary' => 'All contact options',
            ],
            'services' => [
                'eyebrow' => 'Services',
                'heading_a' => 'How I can',
                'heading_b' => 'help.',
                'subtitle' => 'I design and build the systems behind products that need to scale. Here is where I do my best work.',
                'empty' => 'Services coming soon.',
                'cta_a' => 'Have a system that needs to',
                'cta_b' => 'scale?',
                'cta_button' => "Let's talk",
            ],
            'about' => [
                'eyebrow' => 'About',
                'heading_a' => 'I think in',
                'heading_b' => 'systems',
                'heading_c' => 'before screens.',
                'subtitle' => 'The feature is the easy part. The architecture is the work.',
                'short_version' => 'The short version',
                'body' => '',
                'how_a' => 'How I',
                'how_b' => 'work.',
                'where_a' => 'Where I have',
                'where_b' => 'been.',
            ],
            'contact' => [
                'eyebrow' => 'Contact',
                'head_a' => "Let's build something that",
                'head_b' => 'scales.',
                'sub' => 'Hiring, a hard systems problem, or just comparing notes on architecture. I read everything.',
                'form_title' => 'Send a message',
                'reach_me' => 'Reach me',
                'name_label' => 'Name',
                'email_label' => 'Email',
                'subject_label' => 'Subject',
                'message_label' => 'Message',
                'send_button' => 'Send message',
                'sending' => 'Sending…',
                'success' => 'Thanks — I will get back to you soon.',
                'error_default' => 'Failed to send message. Please try again.',
            ],
            'blog' => [
                'eyebrow' => 'Blog',
                'heading_a' => 'Notes on',
                'heading_b' => 'systems.',
                'subtitle' => 'Short pieces on architecture, scale and shipping.',
                'featured' => 'Featured',
                'read_more' => 'Read article →',
                'load_more' => 'Load more',
                'loading' => 'Loading…',
                'no_posts' => 'No posts yet. Check back soon.',
                'back_to_blog' => '← Back to Blog',
                'post_not_found' => 'Post Not Found',
                'min_read' => 'min read',
                'views' => 'views',
            ],
            'footer' => [
                'description' => 'Software engineer building scalable backend systems. PHP, Laravel, Rust, Kafka and Vue.js. AI integration, system design and team leadership.',
                'tagline' => 'Built around one system · shahzaman.dev',
                'quick_links' => 'Quick Links',
                'legal' => 'Legal',
                'privacy' => 'Privacy Policy',
                'terms' => 'Terms & Conditions',
                'rights' => 'All rights reserved.',
            ],
            'privacy' => [
                'heading_a' => 'Privacy',
                'heading_b' => 'Policy.',
                'intro' => 'This site is a personal portfolio. It collects only the information you choose to share through the contact form, and it does not sell or share your data with third parties.',
            ],
            'terms' => [
                'heading_a' => 'Terms &',
                'heading_b' => 'Conditions.',
                'intro' => 'By using this website you agree to the following terms. They are intentionally simple.',
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
