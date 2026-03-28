<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 *
 * Converts any uploaded image to WebP and generates responsive size variants
 * using PHP GD. All variants share the same base hash filename.
 *
 * Size presets (width in px):
 *   lg   — 1440 px  quality 82  →  hero / full-width sections
 *   md   —  800 px  quality 80  →  product pages, content areas
 *   sm   —  480 px  quality 78  →  product cards, grids
 *   th   —  240 px  quality 75  →  media-library thumbnail, tiny previews
 *
 * File naming:
 *   primary  →  {hash}.webp
 *   md       →  {hash}_md.webp
 *   sm       →  {hash}_sm.webp
 *   th       →  {hash}_th.webp
 */

namespace App\Libraries;

class ImageOptimizer
{
    /** Size presets keyed by variant name. */
    private const PRESETS = [
        'lg' => ['w' => 1440, 'q' => 82],
        'md' => ['w' => 800,  'q' => 80],
        'sm' => ['w' => 480,  'q' => 78],
        'th' => ['w' => 240,  'q' => 75],
    ];

    /**
     * Process a source image file:
     *  – Converts to WebP
     *  – Generates up to 4 responsive variants (skips larger-than-source sizes)
     *  – Deletes the original source file after processing
     *
     * @param  string $sourcePath  Absolute path to the temporary / original file
     * @param  string $destDir     Absolute directory to write variants into
     * @param  string $baseName    Base hash string (no extension) used as filename stem
     * @return array{
     *   filename: string,
     *   variants: array<string, array{file:string, w:int, h:int, size:int}>
     * }|array{error: string}
     */
    public function process(string $sourcePath, string $destDir, string $baseName): array
    {
        // Bump memory for large images
        $prevMem = ini_set('memory_limit', '256M');

        $info = @getimagesize($sourcePath);
        if (! $info) {
            return ['error' => 'Cannot read image dimensions.'];
        }

        $src = $this->loadGD($sourcePath, $info[2]);
        if (! $src) {
            return ['error' => 'Unsupported image type or corrupt file.'];
        }

        $origW = imagesx($src);
        $origH = imagesy($src);

        $variants    = [];
        $primaryFile = null;

        foreach (self::PRESETS as $key => $opts) {
            [$targetW, $targetH] = $this->calcDimensions($origW, $origH, $opts['w']);

            $canvas  = $this->createCanvas($targetW, $targetH);
            imagecopyresampled($canvas, $src, 0, 0, 0, 0, $targetW, $targetH, $origW, $origH);

            $filename = $key === 'lg'
                ? $baseName . '.webp'
                : $baseName . '_' . $key . '.webp';

            $destPath = rtrim($destDir, '/') . '/' . $filename;
            imagewebp($canvas, $destPath, $opts['q']);
            imagedestroy($canvas);

            $fileSize = file_exists($destPath) ? filesize($destPath) : 0;

            $variants[$key] = [
                'file' => $filename,
                'w'    => $targetW,
                'h'    => $targetH,
                'size' => $fileSize,
            ];

            if ($key === 'lg') {
                $primaryFile = $filename;
            }
        }

        imagedestroy($src);

        // Remove the original upload (we keep only WebP variants)
        if (is_file($sourcePath)) {
            @unlink($sourcePath);
        }

        if ($prevMem !== false) {
            ini_set('memory_limit', $prevMem);
        }

        return [
            'filename' => $primaryFile,
            'variants' => $variants,
            'orig_w'   => $origW,
            'orig_h'   => $origH,
        ];
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Scale dimensions to fit within $maxW, preserving aspect ratio.
     * Never upscales — returns original dimensions if already smaller.
     */
    private function calcDimensions(int $origW, int $origH, int $maxW): array
    {
        if ($origW <= $maxW) {
            return [$origW, $origH];
        }
        $ratio = $maxW / $origW;
        return [$maxW, (int) round($origH * $ratio)];
    }

    /**
     * Create a true-colour GD canvas with alpha support.
     */
    private function createCanvas(int $w, int $h): \GdImage
    {
        $canvas = imagecreatetruecolor($w, $h);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefill($canvas, 0, 0, $transparent);
        return $canvas;
    }

    /**
     * Load a GD resource from file, handling the main image types.
     */
    private function loadGD(string $path, int $type): \GdImage|false
    {
        return match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            IMAGETYPE_PNG  => $this->loadPng($path),
            IMAGETYPE_WEBP => imagecreatefromwebp($path),
            IMAGETYPE_GIF  => imagecreatefromgif($path),
            IMAGETYPE_BMP  => imagecreatefrombmp($path),
            default        => false,
        };
    }

    /**
     * Load PNG preserving alpha channel.
     */
    private function loadPng(string $path): \GdImage|false
    {
        $img = imagecreatefrompng($path);
        if (! $img) {
            return false;
        }
        imagealphablending($img, false);
        imagesavealpha($img, true);
        return $img;
    }

    // ── Static helpers for view/template use ────────────────────────────────

    /**
     * Return the URL for a specific size variant given the primary filename.
     *
     * @param  string $primaryFilename  e.g. "abc123.webp"
     * @param  string $variant          "lg"|"md"|"sm"|"th"
     * @param  string $folder           media library folder (e.g. "general")
     */
    public static function variantUrl(string $primaryFilename, string $variant, string $folder): string
    {
        $base = pathinfo($primaryFilename, PATHINFO_FILENAME); // strip .webp
        $file = $variant === 'lg' ? $base . '.webp' : $base . '_' . $variant . '.webp';
        return '/uploads/media/' . $folder . '/' . $file;
    }

    /**
     * Build a srcset string from stored variants JSON.
     *
     * @param  string $variantsJson  JSON string from media_library.variants
     * @param  string $folder
     * @param  array  $keys          Which sizes to include, default all
     */
    public static function srcset(string $variantsJson, string $folder, array $keys = ['sm', 'md', 'lg']): string
    {
        $variants = json_decode($variantsJson, true);
        if (! $variants) {
            return '';
        }
        $parts = [];
        foreach ($keys as $key) {
            if (! isset($variants[$key])) {
                continue;
            }
            $v      = $variants[$key];
            $url    = '/uploads/media/' . $folder . '/' . $v['file'];
            $parts[] = $url . ' ' . $v['w'] . 'w';
        }
        return implode(', ', $parts);
    }

    /**
     * Human-readable file size string.
     */
    public static function humanSize(int $bytes): string
    {
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 2) . ' MB';
    }
}
