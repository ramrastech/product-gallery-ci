# OG Image & Social Sharing — Issues, Fixes & Checklist

**Project:** Product Gallery — Ramras Technologies
**Date:** 2026-03-28
**Affected:** WhatsApp, Facebook, Twitter/X, LinkedIn link previews

---

## Issues Found & Fixed

### Issue 1 — Empty string bypassed OG image fallback

**File:** `app/Views/partials/og_meta.php`

**Problem:**
The fallback for the default OG image used the null coalescing operator `??`:
```php
$ogImage = $ogImage ?? base_url('assets/img/og-default.jpg');
```
Controllers (Home, About) passed `$ogImage = ''` (empty string) when no OG image was set.
The `??` operator only triggers on `null`, not on `''`, so the fallback never fired and
`og:image` rendered as a blank string — no image in social previews.

**Fix:**
```php
$ogImage = (!empty($ogImage)) ? $ogImage : base_url('assets/img/og-default.jpg');
```

---

### Issue 2 — WebP format not supported by WhatsApp (and other crawlers)

**Files:** `app/Libraries/ImageOptimizer.php`, `app/Controllers/Admin/MediaLibrary.php`,
`app/Controllers/Admin/Products.php`, `app/Views/admin/media/picker.php`

**Problem:**
All uploaded images are converted to WebP for performance. WhatsApp's link preview
crawler does not support WebP — it silently ignores the `og:image` and shows no image.
This affects Facebook Messenger and some older crawlers too.

**Fix:**
- `ImageOptimizer::process()` — added `$alsoJpeg = true` parameter that generates a
  `{hash}.jpg` JPEG copy alongside the WebP when enabled.
- `MediaLibrary` (og folder) — passes `alsoJpeg: true` so OG uploads always produce a JPEG.
- `Admin/Products` uploads — passes `alsoJpeg: true` so product images always produce a JPEG.
- `media/picker.php` — when an `og_jpeg` variant exists, the picker inserts the `.jpg` URL
  instead of the `.webp` URL into the OG image field.
- `Controllers/Products.php` — OG image URL prefers `.jpg` if it exists on disk,
  falls back to WebP only when no JPEG copy is present.

**Existing images on server:**
A one-time PHP script was run via SSH to generate `.jpg` copies for all 17 existing
product images in `uploads/products/`.

---

### Issue 3 — Double path bug in product OG image URL

**File:** `app/Controllers/Products.php`

**Problem:**
`image_path` in the `product_images` table stores the full relative path:
```
/uploads/products/5f49e9cc5cd74b61.webp
```
But the controller prepended `uploads/products/` before it:
```php
base_url('uploads/products/' . $primaryImage)
// → https://pg.ramrastech.com/uploads/products//uploads/products/5f49e9cc5cd74b61.webp
```
This produced a broken URL — WhatsApp (and all crawlers) got a 404 for the OG image.

**Fix:**
Strip the leading slash and detect if the path is already a full relative path:
```php
$cleanPath  = ltrim($primaryImage, '/');
$jpegPath   = preg_replace('/\.webp$/i', '.jpg', $cleanPath);
$ogImageUrl = is_file(FCPATH . $jpegPath)
    ? base_url($jpegPath)
    : base_url($cleanPath);
```

---

## Project Checklist — Social Sharing & OG Images

Use this checklist whenever adding new image upload points or page types.

### OG Image Format
- [ ] OG images must be **JPEG or PNG** — never WebP
- [ ] WhatsApp, Facebook, LinkedIn all reject WebP silently (no error, just no preview)
- [ ] When uploading to the `og` media folder, a `.jpg` copy is auto-generated — always use that URL
- [ ] Product images: `.jpg` copy is auto-generated alongside WebP — the OG logic picks it automatically

### OG Image Size
- [ ] Minimum: **600 × 315 px**
- [ ] Recommended: **1200 × 630 px** (2:1 ratio)
- [ ] WhatsApp minimum: **300 × 200 px** (but larger is better)
- [ ] File size: keep under **300 KB** for fast crawler fetch

### OG Image URL
- [ ] Must be an **absolute URL** (e.g. `https://pg.ramrastech.com/uploads/...`)
- [ ] URL must be publicly accessible — no auth, no redirect loops
- [ ] Never construct URL by prepending a folder to a path that already contains that folder
- [ ] Use `!empty()` not `??` when falling back from a variable that might be `''`

### Adding a New Page Type
- [ ] Set `$ogImage` in the controller — pass a full `base_url(...)` value, never `''`
- [ ] If the page has no image, use `base_url('assets/img/og-default.jpg')` explicitly
- [ ] Add `og:type` appropriate for the page (`website`, `product`, `article`)
- [ ] Test with the [Facebook Sharing Debugger](https://developers.facebook.com/tools/debug/) before launch

### Adding a New Upload Type
- [ ] If images from this upload will be used as OG images, call `optimizer->process(..., alsoJpeg: true)`
- [ ] Store and use the `.jpg` URL (not `.webp`) for the `og:image` meta tag
- [ ] If images already exist without JPEG copies, run the JPEG generation script below

### After Updating OG Tags
- [ ] WhatsApp caches previews — test with a URL that hasn't been shared before, or append `?v=2`
- [ ] Use [opengraph.xyz](https://www.opengraph.xyz) to verify what crawlers see
- [ ] Facebook cache can be cleared at: https://developers.facebook.com/tools/debug/

---

## JPEG Generation Script (for existing WebP images)

If a batch of existing product images needs JPEG copies, run this on the server via SSH:

```php
<?php
// Save as gen_jpeg.php, run via: php gen_jpeg.php, then delete

$dir   = '/path/to/public_html/uploads/products/';
$files = glob($dir . '*.webp');
$count = 0;

foreach ($files as $webp) {
    if (preg_match('/_(md|sm|th)\.webp$/', $webp)) continue; // skip variants
    $jpg = preg_replace('/\.webp$/', '.jpg', $webp);
    if (file_exists($jpg)) continue;

    $img    = imagecreatefromwebp($webp);
    $w      = imagesx($img);
    $h      = imagesy($img);
    $canvas = imagecreatetruecolor($w, $h);
    $white  = imagecolorallocate($canvas, 255, 255, 255);
    imagefill($canvas, 0, 0, $white);
    imagecopy($canvas, $img, 0, 0, 0, 0, $w, $h);
    imagejpeg($canvas, $jpg, 85);
    imagedestroy($img);
    imagedestroy($canvas);
    $count++;
}

echo $count . " JPEG copies generated.\n";
```

> Always delete the script from the server after running it.

---

## Crawler Support Reference

| Platform | JPEG | PNG | WebP | Min Size |
|---|---|---|---|---|
| WhatsApp | Yes | Yes | No | 300×200 px |
| Facebook / Messenger | Yes | Yes | No | 200×200 px |
| Twitter / X | Yes | Yes | Partial | 144×144 px |
| LinkedIn | Yes | Yes | No | 1200×627 px recommended |
| Telegram | Yes | Yes | Yes | 200×200 px |
| iMessage | Yes | Yes | No | any |

---

*© 2026 Ramras Technologies. All Rights Reserved.*
