# Professional Portfolio Website

A beautiful and professional portfolio website built with Laravel (backend) and Vue.js (frontend) featuring modern UI/UX animations and a comprehensive admin panel.

## 🎨 Design Philosophy

Based on research of successful developer portfolios, this project implements:

- **Single-page scrolling** with smooth animations
- **Dark/Light mode** toggle
- **Glassmorphism** UI elements
- **Parallax scrolling** effects
- **Interactive hover** effects
- **Cursor glow** effects (Brittany Chiang style)
- **Gradient backgrounds** with animations
- **Responsive design** for all devices

## 🏗️ Architecture

### Backend (Laravel 11)
- **Framework**: Laravel 11
- **Database**: SQLite (can be changed to MySQL/PostgreSQL)
- **Authentication**: Laravel Sanctum
- **Media Management**: Spatie Media Library
- **Admin Panel**: Inertia.js + Vue 3

### Frontend (Vue 3)
- **Framework**: Vue 3 with Composition API
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **Animations**: GSAP
- **Routing**: Vue Router 4
- **HTTP Client**: Axios
- **UI Components**: Headless UI

## 📊 Database Schema

### Tables Created:
1. **projects** - Portfolio projects with images, tech stack, and links
2. **experiences** - Work experience with achievements
3. **skills** - Technical skills with proficiency levels
4. **education** - Education and certifications
5. **testimonials** - Client testimonials with ratings
6. **blog_posts** - Blog articles
7. **contact_messages** - Contact form submissions
8. **settings** - Site-wide settings (name, bio, social links, etc.)
9. **media** - Media library for images
10. **personal_access_tokens** - API authentication tokens

## 🚀 Getting Started

### Backend Setup

1. **Navigate to backend directory**:
   \`\`\`bash
   cd backend
   \`\`\`

2. **Install dependencies** (already done):
   \`\`\`bash
   composer install
   \`\`\`

3. **Configure environment**:
   - Update \`.env\` file with your settings
   - Set database connection (currently using SQLite)

4. **Run migrations** (already done):
   \`\`\`bash
   php artisan migrate
   \`\`\`

5. **Seed initial data** (create a seeder):
   \`\`\`bash
   php artisan make:seeder PortfolioSeeder
   php artisan db:seed
   \`\`\`

6. **Start the server**:
   \`\`\`bash
   php artisan serve
   \`\`\`
   Backend will run on: http://localhost:8000

### Frontend Setup

1. **Navigate to frontend directory**:
   \`\`\`bash
   cd frontend
   \`\`\`

2. **Install dependencies** (already done):
   \`\`\`bash
   npm install
   \`\`\`

3. **Create environment file**:
   \`\`\`bash
   cp .env.example .env
   \`\`\`

   Add to \`.env\`:
   \`\`\`
   VITE_API_URL=http://localhost:8000/api
   \`\`\`

4. **Start development server**:
   \`\`\`bash
   npm run dev
   \`\`\`
   Frontend will run on: http://localhost:5173

## 📁 Project Structure

\`\`\`
portfolio/
├── backend/                      # Laravel Backend
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/
│   │   │       └── API/
│   │   │           ├── PortfolioController.php
│   │   │           └── ContactController.php
│   │   └── Models/
│   │       ├── Project.php
│   │       ├── Experience.php
│   │       ├── Skill.php
│   │       ├── Education.php
│   │       ├── Testimonial.php
│   │       ├── BlogPost.php
│   │       ├── ContactMessage.php
│   │       └── Setting.php
│   ├── database/
│   │   └── migrations/
│   └── routes/
│       └── api.php                # API routes
│
├── frontend/                      # Vue 3 Frontend
│   ├── src/
│   │   ├── components/           # UI Components (to be created)
│   │   ├── views/                # Page views
│   │   ├── router/               # Vue Router config
│   │   ├── services/             # API services
│   │   └── composables/          # Vue composables
│   ├── tailwind.config.js
│   └── vite.config.js
│
└── README.md                      # This file
\`\`\`

## 🔌 API Endpoints

### Public Routes:
- \`GET /api/portfolio\` - Get all portfolio data
- \`GET /api/portfolio/projects\` - Get all projects
- \`GET /api/portfolio/projects/{slug}\` - Get single project
- \`GET /api/portfolio/experiences\` - Get work experiences
- \`GET /api/portfolio/skills\` - Get skills (grouped by category)
- \`GET /api/portfolio/blog\` - Get blog posts (paginated)
- \`GET /api/portfolio/blog/{slug}\` - Get single blog post
- \`POST /api/contact\` - Submit contact form

### Admin Routes (Protected):
- To be implemented with Sanctum authentication

## 🎯 Next Steps

### Immediate Tasks:

1. **Create Database Seeder**:
   \`\`\`bash
   cd backend
   php artisan make:seeder PortfolioSeeder
   \`\`\`
   Add your resume data to the seeder

2. **Build Frontend Components**:
   - \`HeroSection.vue\` - Hero with animated gradient background
   - \`ProjectsSection.vue\` - Featured projects grid
   - \`ExperienceSection.vue\` - Timeline of experiences
   - \`SkillsSection.vue\` - Skills with progress bars
   - \`TestimonialsSection.vue\` - Testimonial cards
   - \`ContactSection.vue\` - Contact form

3. **Implement Animations**:
   - Scroll animations with GSAP
   - Parallax effects
   - Hover animations
   - Cursor glow effect

4. **Build Admin Panel**:
   - Install Inertia.js in Laravel
   - Create admin CRUD controllers
   - Build admin UI with Vue 3 + Inertia

5. **Add Dark Mode**:
   - Create dark mode toggle component
   - Store preference in localStorage
   - Apply dark class to HTML element

## 🎨 Design Features to Implement

1. **Hero Section**:
   - Animated gradient background
   - Typing animation for titles
   - Floating particles effect
   - CTA buttons with hover effects

2. **Navigation**:
   - Sticky header with blur effect
   - Smooth scroll to sections
   - Mobile menu with animation

3. **Project Cards**:
   - Glassmorphism cards
   - Image hover effects
   - Technology tags
   - Live demo and GitHub links

4. **Animations**:
   - Fade in on scroll
   - Stagger animations for lists
   - Parallax backgrounds
   - Smooth page transitions

## 🔧 Configuration

### Settings Table Usage:
\`\`\`php
// Set a value
Setting::set('name', 'Shahzaman');
Setting::set('email', 'sheikhshahzaman001@gmail.com');
Setting::set('social_links', json_encode([
    'github' => 'https://github.com/shahzamandev',
    'linkedin' => 'https://linkedin.com/in/shahzamandev'
]), 'json');

// Get a value
$name = Setting::get('name', 'Default Name');
\`\`\`

## 📝 Component Examples

### Example Hero Component:
\`\`\`vue
<template>
  <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Animated gradient background -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600 animate-gradient"></div>

    <!-- Content -->
    <div class="relative z-10 text-center text-white px-4">
      <h1 class="text-6xl font-bold mb-4 animate-slide-up">
        {{ profile?.name }}
      </h1>
      <p class="text-2xl mb-8 animate-slide-up animation-delay-200">
        {{ profile?.title }}
      </p>
      <button class="glass-morphism px-8 py-3 rounded-full hover:scale-105 transition-transform">
        View My Work
      </button>
    </div>
  </section>
</template>
\`\`\`

## 🚢 Deployment

### Backend (Laravel):
- Deploy to: Laravel Forge, DigitalOcean, AWS, or Heroku
- Configure: Environment variables, database, storage

### Frontend (Vue):
- Build: \`npm run build\`
- Deploy to: Vercel, Netlify, or serve from Laravel's public folder

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/)
- [Tailwind CSS](https://tailwindcss.com/)
- [GSAP Animation](https://greensock.com/gsap/)
- [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary)

## 🤝 Support

For issues or questions, refer to:
- Laravel: https://laravel.com/docs
- Vue: https://vuejs.org/guide/
- Tailwind: https://tailwindcss.com/docs

---

**Built with ❤️ using Laravel & Vue.js**
