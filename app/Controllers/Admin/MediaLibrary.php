<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ImageOptimizer;
use App\Models\MediaLibraryModel;

class MediaLibrary extends BaseController
{
    private MediaLibraryModel $model;
    private ImageOptimizer    $optimizer;

    private array $allowedFolders = ['general', 'products', 'categories', 'hero', 'about', 'team', 'og', 'pages'];
    private array $allowedExts    = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

    public function __construct()
    {
        $this->model     = new MediaLibraryModel();
        $this->optimizer = new ImageOptimizer();
    }

    public function index()
    {
        $folder = $this->request->getGet('folder') ?? 'all';
        $files  = $folder === 'all'
            ? $this->model->getAllFiles()
            : $this->model->getFolderFiles($folder);

        $brokenCount = $this->model
            ->groupStart()
                ->where('variants IS NULL')
                ->orWhere('variants', '')
            ->groupEnd()
            ->countAllResults();

        return view('admin/media/index', [
            'pageTitle'     => 'Media Library',
            'files'         => $files,
            'currentFolder' => $folder,
            'folders'       => $this->allowedFolders,
            'brokenCount'   => $brokenCount,
        ]);
    }

    public function upload()
    {
        $file   = $this->request->getFile('media_file');
        $folder = $this->request->getPost('folder') ?? 'general';

        if (! in_array($folder, $this->allowedFolders)) {
            $folder = 'general';
        }

        $err = $this->validateFile($file);
        if ($err) {
            return redirect()->to('/admin/media')->with('error', $err);
        }

        $result = $this->processUpload($file, $folder);
        if (isset($result['error'])) {
            return redirect()->to('/admin/media')->with('error', $result['error']);
        }

        $this->model->insert([
            'filename'      => $result['filename'],
            'original_name' => $file->getClientName(),
            'folder'        => $folder,
            'mime_type'     => 'image/webp',
            'file_size'     => $result['variants']['lg']['size'] ?? 0,
            'width'         => $result['orig_w'],
            'height'        => $result['orig_h'],
            'variants'      => json_encode($result['variants']),
            'alt_text'      => $this->request->getPost('alt_text') ?? '',
            'title'         => $this->request->getPost('title') ?? '',
            'uploaded_by'   => session()->get('admin_id'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/media')->with('success', 'Image optimised and uploaded as WebP.');
    }

    public function delete(int $id)
    {
        $media = $this->model->find($id);
        if (! $media) {
            return redirect()->to('/admin/media')->with('error', 'File not found.');
        }

        $dir = FCPATH . 'uploads/media/' . $media['folder'] . '/';

        // Delete all size variants
        $variants = json_decode($media['variants'] ?? '{}', true) ?: [];
        foreach ($variants as $v) {
            if (! empty($v['file']) && is_file($dir . $v['file'])) {
                @unlink($dir . $v['file']);
            }
        }

        // Fallback: delete primary filename directly
        if (is_file($dir . $media['filename'])) {
            @unlink($dir . $media['filename']);
        }

        $this->model->delete($id);
        return redirect()->to('/admin/media')->with('success', 'File deleted.');
    }

    /**
     * Returns HTML fragment loaded into a Bootstrap modal.
     */
    public function picker()
    {
        $folder = $this->request->getGet('folder') ?? 'all';
        $files  = $folder === 'all'
            ? $this->model->getAllFiles()
            : $this->model->getFolderFiles($folder);

        return view('admin/media/picker', [
            'files'         => $files,
            'currentFolder' => $folder,
            'folders'       => $this->allowedFolders,
        ]);
    }

    /**
     * AJAX upload — returns JSON {success, url, variants, id, error}.
     */
    public function uploadAjax()
    {
        $file   = $this->request->getFile('media_file');
        $folder = $this->request->getPost('folder') ?? 'general';

        if (! in_array($folder, $this->allowedFolders)) {
            $folder = 'general';
        }

        $err = $this->validateFile($file);
        if ($err) {
            return $this->response->setJSON(['success' => false, 'error' => $err]);
        }

        $result = $this->processUpload($file, $folder);
        if (isset($result['error'])) {
            return $this->response->setJSON(['success' => false, 'error' => $result['error']]);
        }

        $id = $this->model->insert([
            'filename'      => $result['filename'],
            'original_name' => $file->getClientName(),
            'folder'        => $folder,
            'mime_type'     => 'image/webp',
            'file_size'     => $result['variants']['lg']['size'] ?? 0,
            'width'         => $result['orig_w'],
            'height'        => $result['orig_h'],
            'variants'      => json_encode($result['variants']),
            'alt_text'      => '',
            'title'         => '',
            'uploaded_by'   => session()->get('admin_id'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        // For OG folder, return the JPEG URL so social crawlers (WhatsApp etc.) can read it
        $ogJpeg = $result['variants']['og_jpeg']['file'] ?? null;
        $url = '/uploads/media/' . $folder . '/' . ($ogJpeg ?? $result['filename']);

        return $this->response->setJSON([
            'success'  => true,
            'id'       => $id,
            'url'      => $url,
            'name'     => $file->getClientName(),
            'variants' => $result['variants'],
        ]);
    }

    /**
     * Rebuild variants JSON for any record where it is NULL or empty.
     * Reads existing WebP files from disk using the known naming convention.
     */
    public function repairVariants()
    {
        $broken = $this->model
            ->groupStart()
                ->where('variants IS NULL')
                ->orWhere('variants', '')
            ->groupEnd()
            ->findAll();

        $fixed  = 0;
        $keys   = ['lg' => '', 'md' => '_md', 'sm' => '_sm', 'th' => '_th'];

        foreach ($broken as $row) {
            $base = preg_replace('/\.webp$/i', '', $row['filename']);
            $dir  = FCPATH . 'uploads/media/' . $row['folder'] . '/';
            $variants = [];

            foreach ($keys as $key => $suffix) {
                $file = $base . $suffix . '.webp';
                $path = $dir . $file;
                if (! is_file($path)) {
                    continue;
                }
                $info = @getimagesize($path);
                $variants[$key] = [
                    'file' => $file,
                    'w'    => $info[0] ?? 0,
                    'h'    => $info[1] ?? 0,
                    'size' => filesize($path),
                ];
            }

            if (empty($variants)) {
                continue;
            }

            // Update dimensions on the record from the lg variant if missing
            $update = ['variants' => json_encode($variants)];
            if (empty($row['width']) && isset($variants['lg'])) {
                $update['width']  = $variants['lg']['w'];
                $update['height'] = $variants['lg']['h'];
            }

            $this->model->update($row['id'], $update);
            $fixed++;
        }

        return redirect()->to('/admin/media')->with(
            $fixed > 0 ? 'success' : 'error',
            $fixed > 0
                ? "{$fixed} file(s) repaired — variant data rebuilt from disk."
                : 'No repairable files found. Variant files may be missing from disk.'
        );
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    private function validateFile(mixed $file): ?string
    {
        if (! $file || ! $file->isValid()) {
            return 'No valid file provided.';
        }
        $ext = strtolower($file->getClientExtension());
        if (! in_array($ext, $this->allowedExts)) {
            return '.' . strtoupper($ext) . ' is not supported. Allowed formats: JPG, PNG, WebP, GIF. HEIC/HEIF photos from iPhone must be converted to JPG first.';
        }
        if ($file->getSize() > 8 * 1024 * 1024) {
            $mb = number_format($file->getSize() / 1048576, 1);
            return "File is {$mb} MB — maximum allowed size is 8 MB.";
        }
        return null;
    }

    /**
     * Move uploaded file to a temp location then run the optimizer.
     */
    private function processUpload(mixed $file, string $folder): array
    {
        $uploadDir = FCPATH . 'uploads/media/' . $folder;
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Move to dir under a temp name first
        $tmpName = bin2hex(random_bytes(12)) . '_orig.' . $file->getClientExtension();
        $file->move($uploadDir, $tmpName);

        $baseName = bin2hex(random_bytes(8)); // final WebP base name

        // OG folder needs a JPEG copy — WhatsApp/social crawlers do not support WebP
        return $this->optimizer->process(
            $uploadDir . '/' . $tmpName,
            $uploadDir,
            $baseName,
            $folder === 'og'
        );
    }
}
