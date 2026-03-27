# Product Gallery

**OEM Leather & Fashion Accessories Showcase Platform**
Built by [RAMRAS TECHNOLOGIES](https://ramrastech.com)

---

## Overview

Product Gallery is a CodeIgniter 4 web application for showcasing and managing OEM leather goods and fashion accessories. It provides a public-facing product catalogue with enquiry functionality and a full-featured admin panel for content management.

---

## Tech Stack

| Layer       | Technology                        |
|-------------|-----------------------------------|
| Framework   | CodeIgniter 4.7                   |
| Language    | PHP 8.2+                          |
| Database    | MySQL 8.0+ (MySQLi driver)        |
| Frontend    | Bootstrap 5.3.3, Bootstrap Icons  |
| Auth        | Session-based, bcrypt passwords   |
| Email       | PHP mail / SMTP via CI4 Email     |

---

## Features

- Product catalogue with categories, search, filtering, and pagination
- Product detail pages with image gallery and enquiry form
- Admin panel — Products, Categories, Enquiries, Settings, SEO, Media, Themes
- Dynamic page content management (Home, About, FAQ, Legal pages)
- Three switchable themes (Default, Dark, Minimal)
- XML sitemap, Schema.org structured data, Open Graph meta tags
- CSRF protection, ForceHTTPS, security headers
- Role-based access control (super_admin, manager, viewer)
- Audit logging of sensitive admin actions
- 2FA via email OTP
- Forgot / reset password flow
- Soft deletes on all key models

---

## Requirements

- PHP 8.2+ with `intl`, `mbstring`, `mysqlnd`, `curl` extensions
- MySQL 8.0+
- Apache with `mod_rewrite` enabled (or Nginx equivalent)
- Composer

---

## Local Setup

```bash
# 1. Clone the repository
git clone <repo-url> product-gallery
cd product-gallery

# 2. Install PHP dependencies
composer install

# 3. Configure environment
cp .env.example .env
# Edit .env — set baseURL, database credentials, encryption key, email

# 4. Generate encryption key
php spark key:generate

# 5. Run migrations
php spark migrate

# 6. Seed initial data (optional)
php spark db:seed ContentSeeder
php spark db:seed ProductionSeeder

# 7. Start dev server
php spark serve
```

Visit `http://localhost:8080` for the public site.
Visit `http://localhost:8080/admin/login` for the admin panel.

---

## Admin Panel

| URL                     | Description              |
|-------------------------|--------------------------|
| `/admin/login`          | Admin login              |
| `/admin/`               | Dashboard                |
| `/admin/products`       | Product management       |
| `/admin/categories`     | Category management      |
| `/admin/enquiries`      | Enquiry CRM              |
| `/admin/settings`       | Site settings            |
| `/admin/themes`         | Theme switcher           |
| `/admin/page-seo`       | SEO metadata             |
| `/admin/media`          | Media library            |
| `/admin/home-content`   | Home page content        |
| `/admin/about-content`  | About page content       |
| `/admin/faq`            | FAQ management           |
| `/admin/page-content/*` | Privacy / Terms editing  |

Default admin credentials are set during seeding — change the password immediately after first login.

---

## Environment Variables

See `.env.example` for the full list. Key variables:

| Variable                    | Description                              |
|-----------------------------|------------------------------------------|
| `CI_ENVIRONMENT`            | `development` or `production`            |
| `app.baseURL`               | Full base URL including trailing slash   |
| `database.default.*`        | Database connection settings             |
| `encryption.key`            | Run `php spark key:generate`             |
| `email.SMTPHost/User/Pass`  | SMTP credentials for email delivery      |

---

## Deployment

See `scripts/deploy.sh` for the deploy script. Set up environment variables on the server and run:

```bash
bash scripts/deploy.sh
```

Schedule the backup script via cron (see `scripts/backup.sh`):

```bash
0 2 * * * /path/to/project/scripts/backup.sh >> /var/log/pg_backup.log 2>&1
```

---

## Architecture

```
app/
├── Config/          — CI4 configuration (filters, routes, email, security)
├── Controllers/
│   ├── Admin/       — Admin panel controllers (auth, products, settings, etc.)
│   └── *.php        — Public controllers (home, products, about, enquiry, sitemap)
├── Filters/         — AdminAuthFilter, RoleFilter
├── Models/          — One model per table, CI4 Model class
├── Database/
│   ├── Migrations/  — Versioned schema changes (never edit existing)
│   └── Seeds/       — ContentSeeder, ProductionSeeder
└── Views/
    ├── layouts/     — public.php, admin.php base layouts
    ├── admin/       — Admin panel views
    └── partials/    — Shared view fragments (OG meta, schema, share buttons)
```

---

## License

Proprietary — © 2026 RAMRAS TECHNOLOGIES. All Rights Reserved.
