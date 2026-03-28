<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 *
 * Bulk-imports images from a local folder exactly as the admin upload does:
 *   – Copies source file to uploads/products/
 *   – Runs ImageOptimizer → WebP (lg/md/sm/th variants)
 *   – Inserts one product per image + one product_image record
 *
 * Usage:
 *   php spark import:products
 *   php spark import:products --dry-run           (preview, no DB / file changes)
 *   php spark import:products --category=15       (override category id)
 */

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Libraries\ImageOptimizer;

class ImportProductImages extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'import:products';
    protected $description = 'Bulk-import product images from local folder with WebP conversion';

    // ── Source folders to import ─────────────────────────────────────────────
    private const SOURCES = [
        [
            'folder'      => '/Users/rpsrathore/Pictures/Stock Images/Product Showcase/Product-Bags',
            'category_id' => 13,   // Ladies' Handbags
        ],
    ];

    // Destination directory (relative to FCPATH)
    private const DEST_SUBDIR = 'uploads/products';

    public function run(array $params): void
    {
        $dryRun     = array_key_exists('dry-run', $params);
        $categoryOverride = isset($params['category']) ? (int) $params['category'] : null;

        $db          = \Config\Database::connect();
        $optimizer   = new ImageOptimizer();
        $destDir     = FCPATH . self::DEST_SUBDIR;

        if (! is_dir($destDir)) {
            CLI::error('Destination directory does not exist: ' . $destDir);
            return;
        }

        $totalImported = 0;
        $totalSkipped  = 0;

        foreach (self::SOURCES as $source) {
            $folder     = $source['folder'];
            $categoryId = $categoryOverride ?? $source['category_id'];

            CLI::write('');
            CLI::write('Source : ' . $folder, 'cyan');
            CLI::write('Cat ID : ' . $categoryId, 'cyan');

            if (! is_dir($folder)) {
                CLI::error('  Folder not found, skipping.');
                continue;
            }

            $images = $this->collectImages($folder);
            CLI::write('Found  : ' . count($images) . ' unique images', 'yellow');

            foreach ($images as $srcPath) {
                $basename = basename($srcPath);
                $label    = CLI::color($basename, 'white');

                // Check if already imported by matching original filename hint in alt_text
                $productName = $this->makeProductName($basename);
                $slug        = $this->makeSlug($productName, $db);

                // Check duplicate slug (means already imported)
                $existing = $db->table('products')
                               ->where('slug', $slug)
                               ->where('deleted_at IS NULL', null, false)
                               ->get()->getRow();

                if ($existing) {
                    CLI::write('  SKIP  (already imported) → ' . $label, 'dark_gray');
                    $totalSkipped++;
                    continue;
                }

                if ($dryRun) {
                    CLI::write('  [dry] Would import → ' . $label . ' as "' . $productName . '"', 'green');
                    $totalImported++;
                    continue;
                }

                // ── Copy source → temp file in dest dir ──────────────────────
                $ext     = strtolower(pathinfo($srcPath, PATHINFO_EXTENSION));
                $tmpName = bin2hex(random_bytes(8)) . '_orig.' . $ext;
                $tmpPath = $destDir . '/' . $tmpName;

                if (! copy($srcPath, $tmpPath)) {
                    CLI::error('  ERROR copying ' . $basename);
                    continue;
                }

                // ── Run WebP optimizer ────────────────────────────────────────
                $baseName = bin2hex(random_bytes(8));
                $result   = $optimizer->process($tmpPath, $destDir, $baseName);

                if (isset($result['error'])) {
                    CLI::error('  ERROR processing ' . $basename . ': ' . $result['error']);
                    @unlink($tmpPath);
                    continue;
                }

                $primaryFile = $result['filename'];            // e.g. abc123.webp
                $imagePath   = '/' . self::DEST_SUBDIR . '/' . $primaryFile;

                // ── Insert product ────────────────────────────────────────────
                $now = date('Y-m-d H:i:s');

                $productId = $db->table('products')->insert([
                    'category_id'       => $categoryId,
                    'name'              => $productName,
                    'slug'              => $slug,
                    'short_description' => '',
                    'description'       => '',
                    'specifications'    => null,
                    'sku'               => null,
                    'is_featured'       => 0,
                    'is_active'         => 1,
                    'meta_title'        => $productName,
                    'meta_description'  => '',
                    'view_count'        => 0,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ]);

                if (! $productId) {
                    CLI::error('  ERROR inserting product for ' . $basename);
                    continue;
                }

                $productId = $db->insertID();

                // ── Insert product_image ──────────────────────────────────────
                $db->table('product_images')->insert([
                    'product_id' => $productId,
                    'image_path' => $imagePath,
                    'alt_text'   => $productName,
                    'sort_order' => 0,
                    'is_primary' => 1,
                    'created_at' => $now,
                ]);

                $variants = $result['variants'];
                $sizes    = implode(' | ', array_map(
                    fn($k, $v) => $k . ':' . $v['w'] . 'x' . $v['h'],
                    array_keys($variants),
                    $variants
                ));

                CLI::write('  OK    → ' . $label, 'green');
                CLI::write('         ' . $primaryFile . '  [' . $sizes . ']', 'dark_gray');

                $totalImported++;
            }
        }

        CLI::write('');
        CLI::write('Done. Imported: ' . $totalImported . '  Skipped: ' . $totalSkipped, 'green');
        if ($dryRun) {
            CLI::write('(dry-run — no changes written)', 'yellow');
        }
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Collect unique, importable images from a folder.
     *
     * Rules:
     *  – Include: .jpg, .jpeg, .png, .webp
     *  – Exclude: files containing " Medium" (lower-quality duplicates)
     *  – Exclude: files containing "(1)" (duplicate copies)
     *  – If both .jpg and .webp exist for the same base name, prefer .jpg
     */
    private function collectImages(string $folder): array
    {
        $all = glob($folder . '/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', GLOB_BRACE);
        if (! $all) {
            return [];
        }

        // Filter out unwanted files
        $all = array_filter($all, function (string $path): bool {
            $name = basename($path);
            if (str_contains($name, ' Medium'))  return false;
            if (str_contains($name, '(1)'))      return false;
            return true;
        });

        // Deduplicate by base name — prefer jpg/jpeg over webp
        $byBase = [];
        foreach ($all as $path) {
            $name = basename($path);
            $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $base = pathinfo($name, PATHINFO_FILENAME);

            if (! isset($byBase[$base])) {
                $byBase[$base] = $path;
            } else {
                // Prefer jpg/jpeg over webp/png
                $existing_ext = strtolower(pathinfo($byBase[$base], PATHINFO_EXTENSION));
                $jpgTypes = ['jpg', 'jpeg'];
                if (in_array($ext, $jpgTypes) && ! in_array($existing_ext, $jpgTypes)) {
                    $byBase[$base] = $path;
                }
            }
        }

        return array_values($byBase);
    }

    /**
     * Convert a filename to a human-readable product name.
     * e.g. "beige-white-handbag-with-gold-hardware-strap-generative-ai.jpg"
     *   → "Beige White Handbag With Gold Hardware Strap"
     */
    private function makeProductName(string $filename): string
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);

        // Strip noise suffixes from the END only (order matters: longest first)
        $noisePatterns = [
            '-generative-ai',
            '-3d-render-realisti',
            '-3d-render',
            '-generative',
            '-white-background',
            '-isolated-white',
            '-isolated',
            '-background',
            '-concept-design',
            '-realisti',
        ];
        foreach ($noisePatterns as $suffix) {
            $escaped = preg_quote($suffix, '/');
            $name    = preg_replace('/' . $escaped . '$/i', '', $name);
        }

        // Replace hyphens / underscores with spaces, title-case
        $name = str_replace(['-', '_'], ' ', $name);
        $name = preg_replace('/\s+/', ' ', trim($name));
        $name = ucwords($name);

        // Truncate if very long
        if (mb_strlen($name) > 100) {
            $name = mb_substr($name, 0, 97) . '...';
        }

        return $name;
    }

    /**
     * Generate a unique URL slug, appending a counter if necessary.
     */
    private function makeSlug(string $name, \CodeIgniter\Database\BaseConnection $db): string
    {
        $base = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
        $base = trim($base, '-');
        $slug = $base;
        $i    = 2;

        while (
            $db->table('products')
               ->where('slug', $slug)
               ->where('deleted_at IS NULL', null, false)
               ->countAllResults() > 0
        ) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
