# Changelog

All notable changes to **Product Gallery** will be documented in this file.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).
This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.1] — 2026-03-28

### Fixed
- OG image fallback used `??` which ignored empty string — changed to `!empty()` so default image fires correctly
- WhatsApp and social crawlers do not support WebP — media library, product uploads, and OG folder now auto-generate a JPEG copy alongside WebP; OG meta always uses the JPEG URL
- Product OG image URL had a double-path bug — `image_path` already contains `/uploads/products/` but controller prepended it again, producing a broken URL
- Media picker was returning WebP URL for `og` folder images even when a JPEG copy existed
- Added `docs/og-image-social-sharing.md` — issue log and project checklist for social sharing

---

## [1.0.0] — 2026-03-27

### Added
- Initial release of Product Gallery — OEM Leather & Fashion Accessories Platform
- Public-facing product catalogue with category filtering, search, and pagination
- Product detail pages with image gallery, specifications, and enquiry form
- Admin panel with session-based authentication and bcrypt password hashing
- Product CRUD with multi-image upload, reordering, and primary image designation
- Category management with product counts
- Enquiry management with status tracking (new / read / replied)
- Dynamic home page content management (stats, capabilities, materials, markets, certifications)
- Dynamic about page content management (timeline, facility stats, photos, team)
- FAQ management with categories and drag-and-drop reordering
- Legal page editor (Privacy Policy, Terms & Conditions)
- Per-page SEO meta management (title, description, keywords, OG image)
- Media library with folder organisation (general, hero, about, team, og, pages)
- Three theme options: Default, Dark, Minimal — switchable from admin panel
- Site-wide settings (name, tagline, contact details, social links, email config)
- XML sitemap generation
- Schema.org structured data and Open Graph / Twitter Card meta tags
- Bootstrap 5.3.3 responsive layout (tested at 375 px, 768 px, 1280 px)
- CSRF protection, security headers, and ForceHTTPS filter
- CodeIgniter 4.7 framework on PHP 8.2+, MySQL database
- Database migrations (13), production seeders, and content seeders
- Copyright headers across all source files — © 2026 RAMRAS TECHNOLOGIES

---

© 2026 RAMRAS TECHNOLOGIES. All Rights Reserved.
