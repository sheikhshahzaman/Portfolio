<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Testimonial;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // Personal Information
        Setting::set('name', 'Shahzaman');
        Setting::set('title', 'Full-Stack Developer');
        Setting::set('bio', 'I\'m a passionate Full-Stack Developer with 4 years of experience in building secure, scalable, and high traffic web applications using PHP, Laravel, Vue.js, and Inertia.js. I\'ve worked with startups and tech firms to develop SaaS tools, CMS platforms, eCommerce systems, and AI-based apps always focusing on performance, usability, and clean architecture.');
        Setting::set('email', 'sheikhshahzaman001@gmail.com');
        Setting::set('phone', '+92-321-550-5100');
        Setting::set('location', 'Faisalabad, Pakistan');
        Setting::set('social_links', json_encode([
            'github' => 'https://github.com/sheikhshahzaman',
            'linkedin' => 'https://linkedin.com/in/shahzamandev',
        ]), 'json');

        // Projects
        Project::create([
            'title' => 'Summarizer.org',
            'slug' => 'summarizer-org',
            'short_description' => 'Scaled the platform to 1M+ users. Built and optimized 30+ tools, APIs, and mobile integrations.',
            'description' => 'Led the development of a large-scale AI-powered summarization platform serving over 1 million users. Built and optimized 30+ tools including text summarization, paraphrasing, and content analysis features. Integrated mobile APIs and implemented performance optimizations to handle high traffic volumes.',
            'category' => 'SaaS Platform',
            'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'AI/ML APIs', 'REST APIs'],
            'demo_url' => 'https://summarizer.org',
            'is_featured' => true,
            'is_published' => true,
            'order' => 1
        ]);

        Project::create([
            'title' => 'Paraphrasing.io',
            'slug' => 'paraphrasing-io',
            'short_description' => 'AI-powered content platform with free & premium models.',
            'description' => 'Delivered a comprehensive AI-powered content generation platform featuring multiple paraphrasing modes, tone adjustments, and content optimization tools. Implemented subscription-based pricing with free and premium tiers.',
            'category' => 'AI Platform',
            'technologies' => ['Laravel', 'Vue.js', 'AI APIs', 'Payment Integration'],
            'demo_url' => 'https://paraphrasing.io',
            'is_featured' => true,
            'is_published' => true,
            'order' => 2
        ]);

        Project::create([
            'title' => 'Imagetotext.io',
            'slug' => 'imagetotext-io',
            'short_description' => 'SEO-optimized tool site with advanced features like image/PDF converters.',
            'description' => 'Built an OCR-based image to text conversion platform with advanced features including PDF text extraction, multi-language support, and batch processing capabilities. Optimized for SEO with fast loading times and clean UI.',
            'category' => 'Utility Tool',
            'technologies' => ['Laravel', 'OCR Technology', 'PDF Processing'],
            'demo_url' => 'https://imagetotext.io',
            'is_featured' => true,
            'is_published' => true,
            'order' => 3
        ]);

        Project::create([
            'title' => 'Naz Fabrics E-commerce',
            'slug' => 'naz-fabrics',
            'short_description' => 'Full-featured e-commerce platform with admin and user dashboards.',
            'description' => 'Developed a complete e-commerce solution with product management, shopping cart, payment integration, and courier API integration for real-time delivery tracking. Features include product reviews, dynamic blogs, and responsive design.',
            'category' => 'E-commerce',
            'technologies' => ['Laravel', 'MySQL', 'Payment Gateways', 'Courier APIs'],
            'is_featured' => false,
            'is_published' => true,
            'order' => 4
        ]);

        Project::create([
            'title' => 'Property PK',
            'slug' => 'property-pk',
            'short_description' => 'Real estate platform with property listing management.',
            'description' => 'Built a real estate web application with advanced search filters, property listings, agent management, and custom CMS panel. Focused on performance and SEO optimization for better visibility.',
            'category' => 'Real Estate',
            'technologies' => ['Laravel', 'MySQL', 'Custom CMS'],
            'is_featured' => false,
            'is_published' => true,
            'order' => 5
        ]);

        // Work Experience
        Experience::create([
            'company' => 'Enzipe',
            'position' => 'Full Stack Developer',
            'location' => 'Faisalabad',
            'start_date' => '2023-10-01',
            'is_current' => true,
            'description' => 'Working as a team lead and full-stack developer on large scale platforms with over 1M users.',
            'achievements' => [
                'Scaled Summarizer.org platform to 1M+ users',
                'Built and optimized 30+ tools, APIs, and mobile integrations',
                'Delivered Paraphrasing.io AI-powered content platform with free & premium models',
                'Developed Imagetotext.io with advanced OCR features',
                'Built Matgarli SaaS Platform with order/product management and payment integrations'
            ],
            'order' => 1
        ]);

        Experience::create([
            'company' => 'TechTrack',
            'position' => 'Senior Laravel Developer',
            'location' => 'Remote',
            'start_date' => '2023-01-01',
            'end_date' => '2023-10-01',
            'is_current' => false,
            'description' => 'Led the core development of two major platforms and mentored junior developers.',
            'achievements' => [
                'Built Taam-AI platform with text generation and image recognition features',
                'Developed RS Taxi booking system with admin/rider dashboards',
                'Mentored junior developers and improved project delivery by ~30%',
                'Implemented secure authentication and payment systems'
            ],
            'order' => 2
        ]);

        Experience::create([
            'company' => 'Sunztech International',
            'position' => 'Laravel Developer',
            'location' => 'Remote',
            'start_date' => '2021-09-01',
            'end_date' => '2023-01-01',
            'is_current' => false,
            'description' => 'Developed multiple web applications including AI chatbot systems and utility tools.',
            'achievements' => [
                'Created AI Chatbot System with ChatGPT-like real-time interaction',
                'Built Minifier.org for CSS, JS, and HTML optimization',
                'Developed POS System for inventory and billing management',
                'Enhanced UI/UX and implemented secure login systems',
                'Managed and mentored junior developers'
            ],
            'order' => 3
        ]);

        // Skills
        // Backend
        Skill::create(['name' => 'PHP', 'category' => 'Backend', 'proficiency' => 95, 'order' => 1]);
        Skill::create(['name' => 'Laravel', 'category' => 'Backend', 'proficiency' => 95, 'order' => 2]);

        // Frontend
        Skill::create(['name' => 'Vue.js', 'category' => 'Frontend', 'proficiency' => 90, 'order' => 3]);
        Skill::create(['name' => 'Inertia.js', 'category' => 'Frontend', 'proficiency' => 85, 'order' => 4]);
        Skill::create(['name' => 'JavaScript', 'category' => 'Frontend', 'proficiency' => 90, 'order' => 5]);
        Skill::create(['name' => 'HTML/CSS', 'category' => 'Frontend', 'proficiency' => 95, 'order' => 6]);

        // Database
        Skill::create(['name' => 'MySQL', 'category' => 'Database', 'proficiency' => 90, 'order' => 7]);
        Skill::create(['name' => 'MariaDB', 'category' => 'Database', 'proficiency' => 85, 'order' => 8]);

        // Tools & Others
        Skill::create(['name' => 'Git', 'category' => 'Tools', 'proficiency' => 85, 'order' => 9]);
        Skill::create(['name' => 'REST APIs', 'category' => 'Tools', 'proficiency' => 90, 'order' => 10]);
        Skill::create(['name' => 'MVC Architecture', 'category' => 'Tools', 'proficiency' => 90, 'order' => 11]);

        // Education
        Education::create([
            'degree' => 'BS Computer Science',
            'institution' => 'Virtual University',
            'start_date' => '2018-01-01',
            'end_date' => '2022-06-01',
            'is_current' => false,
            'type' => 'degree',
            'order' => 1
        ]);

        Education::create([
            'degree' => 'PHP Developer Certification',
            'institution' => 'Corvit Software House',
            'start_date' => '2020-01-01',
            'end_date' => '2020-06-01',
            'is_current' => false,
            'type' => 'certification',
            'order' => 2
        ]);

        // Sample Testimonials
        Testimonial::create([
            'name' => 'Client Name',
            'position' => 'CEO',
            'company' => 'Tech Company',
            'content' => 'Shahzaman is an exceptional developer who delivered our project on time and exceeded expectations. His expertise in Laravel and Vue.js helped us build a scalable platform.',
            'rating' => 5,
            'is_featured' => true,
            'order' => 1
        ]);

        $this->command->info('Portfolio data seeded successfully!');
    }
}
