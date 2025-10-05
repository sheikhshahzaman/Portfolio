# Portfolio

A professional portfolio website built with Laravel 11 and Vue.js featuring a modern UI/UX design and a comprehensive admin panel.

## Features

- 🎨 Modern, responsive design with dark mode support
- 📱 Single-page scrolling homepage with smooth navigation
- 🔐 Secure admin panel with Laravel Breeze authentication
- 📝 Full CRUD operations for Projects, Experiences, Skills, Education, Testimonials, and Blog Posts
- 🖼️ Image upload with Spatie Media Library
- ⚙️ Site settings management
- 📊 RESTful API for portfolio data
- ✨ Beautiful animations with Tailwind CSS

## Tech Stack

- **Backend:** Laravel 11, Sanctum, Inertia.js, Spatie Media Library
- **Frontend:** Vue 3, Vue Router 4, Vite, Tailwind CSS v3
- **Database:** SQLite/MySQL

## Installation

1. Clone repository
```bash
git clone https://github.com/sheikhshahzaman/Portfolio.git
cd Portfolio
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env` and run migrations
```bash
php artisan migrate
php artisan db:seed --class=PortfolioSeeder
php artisan storage:link
```

5. Build assets and start server
```bash
npm run build
php artisan serve
```

6. Access application
- Portfolio: http://127.0.0.1:8000
- Admin: http://127.0.0.1:8000/dashboard (register first)

## API Endpoints

- `GET /api/portfolio` - All portfolio data
- `GET /api/portfolio/projects` - All projects
- `GET /api/portfolio/projects/{slug}` - Single project
- `POST /api/contact` - Submit contact form

## Admin Panel

Protected routes at `/admin/*`:
- `/admin/projects` - Manage projects
- `/admin/experiences` - Manage work experience
- `/admin/skills` - Manage skills
- `/admin/education` - Manage education
- `/admin/testimonials` - Manage testimonials
- `/admin/blog-posts` - Manage blog posts
- `/admin/settings` - Site settings

## Development

```bash
composer run dev  # Runs Laravel server, queue, logs, and Vite
```

## License

MIT License

## Author

**Shahzaman**
- GitHub: [@sheikhshahzaman](https://github.com/sheikhshahzaman)
- LinkedIn: [shahzamandev](https://linkedin.com/in/shahzamandev)
