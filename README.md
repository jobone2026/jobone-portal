# JobOne.in - Government Job Portal

A comprehensive Laravel-based platform for Indian government job seekers, providing latest updates on SSC, UPSC, Railways, Banking, State PSC, Defence, Police, and Teaching jobs.

## Features

### Core Features
- **Job Listings**: Latest government job notifications with detailed information
- **Multiple Post Types**: Jobs, Results, Admit Cards, Answer Keys, Syllabus, Blogs
- **Category Management**: SSC, UPSC, Railways, Banking, State PSC, Defence, Police, Teaching
- **State-wise Filtering**: 28 Indian states coverage
- **Advanced Search**: Full-text search across all posts
- **Admin Panel**: Complete CRUD operations for content management

### SEO & Performance
- **Comprehensive SEO**: Meta tags, structured data (JSON-LD), Open Graph tags
- **250+ Keywords**: Strategic keyword targeting (110 general + 140 state-specific)
- **Smart Caching**: Page-level caching with configurable TTL
- **Sitemaps**: Automated sitemap generation (posts, categories, states, news)
- **IndexNow Integration**: Automatic URL submission to search engines
- **OG Image Generation**: Auto-generated social media preview images
- **Core Web Vitals Optimized**: Lazy loading, asset optimization

### API
- **REST API**: Full CRUD operations via API
- **Token Authentication**: Laravel Sanctum integration
- **Postman Collection**: Ready-to-use API testing collection

### Analytics & Tracking
- **Google Analytics 4**: Integrated with custom events
- **View Counter**: Track post popularity
- **SEO Analyzer**: Real-time SEO analysis in admin panel

## Tech Stack

- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Database**: MySQL 8.0
- **Frontend**: Tailwind CSS 4.2.1, Alpine.js
- **Build Tool**: Vite 7.0.7
- **Cache**: File-based (Redis-ready)
- **Queue**: Database driver

## Requirements

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Node.js >= 18.x
- NPM
- PHP Extensions: GD, BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Installation

### Local Development

1. **Clone Repository**
```bash
git clone https://github.com/jobone2026/jobone-portal.git
cd jobone-portal
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure Database**
Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=govt_job_portal
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run Migrations**
```bash
php artisan migrate
```

6. **Build Assets**
```bash
npm run build
```

7. **Start Development Server**
```bash
php artisan serve
```

Visit: `http://localhost:8000`

### Production Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for complete AWS deployment guide.

## Configuration

### Admin Access

Create admin user:
```bash
php artisan tinker
```

```php
$admin = new App\Models\Admin();
$admin->name = 'Admin';
$admin->email = 'admin@example.com';
$admin->password = bcrypt('password123');
$admin->save();
```

Admin Panel: `/admin/login`

### Queue Worker

Start queue worker for background jobs:
```bash
php artisan queue:work
```

### Scheduled Tasks

Add to crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

Scheduled tasks:
- Daily sitemap generation (2:00 AM)

## API Documentation

See [API_DOCUMENTATION.md](API_DOCUMENTATION.md) for complete API reference.

### Quick Start

1. **Generate API Token**
```bash
POST /api/admin/token
{
  "email": "admin@example.com",
  "password": "password123"
}
```

2. **Create Post**
```bash
POST /api/admin/posts
Authorization: Bearer {token}
{
  "title": "SSC CGL 2026",
  "type": "job",
  "category_id": 1,
  "content": "...",
  ...
}
```

## Project Structure

```
govt-job-portal/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   ├── Api/            # API controllers
│   │   └── ...             # Public controllers
│   ├── Models/             # Eloquent models
│   ├── Services/           # Business logic services
│   └── View/Components/    # Blade components
├── config/
│   ├── seo_keywords.php    # SEO keyword configuration
│   └── state_keywords.php  # State-specific keywords
├── database/
│   └── migrations/         # Database migrations
├── public/                 # Public assets
├── resources/
│   ├── views/              # Blade templates
│   └── js/                 # JavaScript files
├── routes/
│   ├── web.php             # Web routes
│   ├── api.php             # API routes
│   └── console.php         # Console routes
└── storage/                # File storage
```

## Key Services

### SeoService
Handles meta tags, titles, descriptions, and keywords generation.

### SchemaService
Generates JSON-LD structured data for search engines.

### CacheService & CacheInvalidationService
Manages page-level caching and cache invalidation.

### IndexNowService
Submits URLs to search engines for instant indexing.

### OgImageService
Auto-generates Open Graph images for social media sharing.

### CategorySeoContentService
Provides SEO-optimized content for category pages.

## SEO Features

- **Meta Tags**: Dynamic title, description, keywords
- **Structured Data**: JobPosting, Article, BreadcrumbList, WebSite, Organization, FAQPage
- **Open Graph**: Facebook, Twitter card support
- **Canonical URLs**: Prevent duplicate content
- **Sitemaps**: XML sitemaps for all content types
- **Robots.txt**: Search engine crawling directives
- **IndexNow**: Real-time search engine notification

## Performance

- **Page Caching**: 1-hour TTL for public pages
- **Asset Optimization**: Minified CSS/JS, lazy loading images
- **Database Indexing**: Optimized queries with proper indexes
- **CDN-Ready**: Static assets can be served via CDN
- **Gzip Compression**: Enabled for text-based assets

## Security

- **CSRF Protection**: Laravel's built-in CSRF protection
- **SQL Injection Prevention**: Eloquent ORM with prepared statements
- **XSS Protection**: Blade template escaping
- **Authentication**: Secure admin authentication
- **API Authentication**: Token-based (Laravel Sanctum)
- **Environment Variables**: Sensitive data in .env file

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is proprietary software. All rights reserved.

## Support

- **Email**: jobone2026@gmail.com
- **Website**: https://jobone.in

## Changelog

### Version 1.0.0 (March 2026)
- Initial release
- Complete SEO implementation
- REST API with Sanctum authentication
- Admin panel with CRUD operations
- 250+ keyword strategy
- Automated sitemap generation
- OG image generation
- Google Analytics integration
- IndexNow integration

## Credits

- **Framework**: [Laravel](https://laravel.com)
- **CSS**: [Tailwind CSS](https://tailwindcss.com)
- **Icons**: [Font Awesome](https://fontawesome.com)
- **JavaScript**: [Alpine.js](https://alpinejs.dev)

---

**Built with ❤️ for Indian Job Seekers**

**© 2026 JobOne.in. All rights reserved.**
