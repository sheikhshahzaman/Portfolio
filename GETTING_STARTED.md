# Getting Started with Your Portfolio

## Quick Start Guide

### 1. Start the Backend (Laravel)

\`\`\`bash
cd backend
php artisan serve
\`\`\`

Your API will be available at: **http://localhost:8000**

### 2. Start the Frontend (Vue)

\`\`\`bash
cd frontend
npm run dev
\`\`\`

Your portfolio will be available at: **http://localhost:5173**

---

## Next Steps

### Step 1: Populate Your Data

Create a database seeder with your resume information:

\`\`\`bash
cd backend
php artisan make:seeder PortfolioSeeder
\`\`\`

Edit `backend/database/seeders/PortfolioSeeder.php`:

\`\`\`php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Education;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        // Personal Info
        Setting::set('name', 'Shahzaman');
        Setting::set('title', 'Full-Stack Developer');
        Setting::set('bio', 'I\'m a passionate Full-Stack Developer with 4 years of experience...');
        Setting::set('email', 'sheikhshahzaman001@gmail.com');
        Setting::set('phone', '+92-321-550-5100');
        Setting::set('location', 'Faisalabad');
        Setting::set('social_links', json_encode([
            'github' => 'https://github.com/shahzamandev',
            'linkedin' => 'https://linkedin.com/in/shahzamandev',
        ]), 'json');

        // Projects
        Project::create([
            'title' => 'Summarizer.org',
            'slug' => 'summarizer-org',
            'short_description' => 'Scaled platform to 1M+ users',
            'description' => 'Built and optimized 30+ tools, APIs, and mobile integrations...',
            'category' => 'SaaS',
            'technologies' => ['Laravel', 'Vue.js', 'MySQL'],
            'demo_url' => 'https://summarizer.org',
            'is_featured' => true,
            'is_published' => true,
            'order' => 1
        ]);

        // Experiences
        Experience::create([
            'company' => 'Enzipe',
            'position' => 'Full Stack Developer',
            'location' => 'Faisalabad',
            'start_date' => '2023-10-01',
            'is_current' => true,
            'description' => 'Team lead and full-stack developer on large scale platforms',
            'achievements' => [
                'Scaled Summarizer.org to 1M+ users',
                'Built 30+ tools and APIs',
                'Led development team'
            ],
            'order' => 1
        ]);

        // Skills
        Skill::create(['name' => 'PHP', 'category' => 'Backend', 'proficiency' => 95, 'order' => 1]);
        Skill::create(['name' => 'Laravel', 'category' => 'Backend', 'proficiency' => 95, 'order' => 2]);
        Skill::create(['name' => 'Vue.js', 'category' => 'Frontend', 'proficiency' => 90, 'order' => 3]);
        Skill::create(['name' => 'MySQL', 'category' => 'Database', 'proficiency' => 85, 'order' => 4]);

        // Education
        Education::create([
            'degree' => 'BS Computer Science',
            'institution' => 'Virtual University',
            'start_date' => '2018-01-01',
            'end_date' => '2022-06-01',
            'type' => 'degree',
            'order' => 1
        ]);
    }
}
\`\`\`

Run the seeder:

\`\`\`bash
php artisan db:seed --class=PortfolioSeeder
\`\`\`

### Step 2: Test the API

Visit: http://localhost:8000/api/portfolio

You should see all your portfolio data!

### Step 3: Enhance Animations

The GSAP library is already installed. Add scroll animations:

\`\`\`javascript
// In your component
import { onMounted } from 'vue'
import gsap from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)

onMounted(() => {
  gsap.from('.project-card', {
    scrollTrigger: {
      trigger: '.project-card',
      start: 'top 80%',
    },
    y: 50,
    opacity: 0,
    duration: 0.8,
    stagger: 0.2
  })
})
\`\`\`

### Step 4: Build Admin Panel

1. Set up Inertia admin routes:

\`\`\`php
// routes/web.php
use App\Http\Controllers\Admin\ProjectController;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::resource('experiences', ExperienceController::class);
    Route::resource('skills', SkillController::class);
    // ... other resources
});
\`\`\`

2. Create admin controllers:

\`\`\`bash
php artisan make:controller Admin/ProjectController --resource
\`\`\`

3. Set up Inertia pages in `resources/js/Pages/Admin/`

### Step 5: Add Authentication

\`\`\`bash
php artisan make:auth
\`\`\`

Or use Laravel Breeze for a quick setup:

\`\`\`bash
composer require laravel/breeze --dev
php artisan breeze:install vue
npm install && npm run dev
\`\`\`

### Step 6: Enable CORS (if needed)

Edit `config/cors.php`:

\`\`\`php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['http://localhost:5173'],
\`\`\`

---

## Current Features ✅

- ✅ Laravel 11 backend with REST API
- ✅ Vue 3 frontend with Tailwind CSS
- ✅ Dark/Light mode toggle
- ✅ Responsive design
- ✅ Database schema for portfolio data
- ✅ API endpoints for all content
- ✅ Contact form functionality
- ✅ Basic animations
- ✅ SEO-friendly routing

## To-Do Features 📋

- 🔲 GSAP scroll animations
- 🔲 Admin panel with Inertia.js
- 🔲 Authentication system
- 🔲 Image upload with Spatie Media Library
- 🔲 Blog with rich text editor
- 🔲 Analytics dashboard
- 🔲 Email notifications
- 🔲 SEO meta tags
- 🔲 Sitemap generation
- 🔲 Performance optimizations

---

## Troubleshooting

### CORS Issues

If you get CORS errors, make sure:
1. Laravel is running on port 8000
2. Vue is running on port 5173
3. CORS is properly configured in `config/cors.php`

### Database Connection

If migrations fail:
- Check your `.env` file
- Make sure database exists
- Run: \`php artisan config:clear\`

### Vue Not Loading

- Make sure all npm packages are installed: \`npm install\`
- Clear cache: \`npm run dev -- --force\`
- Check console for errors

---

## Resources

- **Laravel Docs**: https://laravel.com/docs
- **Vue 3 Docs**: https://vuejs.org/
- **Tailwind CSS**: https://tailwindcss.com/docs
- **GSAP**: https://greensock.com/docs/
- **Inertia.js**: https://inertiajs.com/

---

**Happy Coding! 🚀**
