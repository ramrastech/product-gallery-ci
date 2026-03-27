<?php

/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @company    Ramras Technologies
 * @developer  RPS Rathore
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MediaLibraryModel;

class MediaLibrary extends BaseController
{
    private MediaLibraryModel $model;

    private array $allowedFolders = ['general', 'hero', 'about', 'team', 'og', 'pages'];

    public function __construct()
    {
        $this->model = new MediaLibraryModel();
    }

    public function index()
    {
        $folder = $this->request->getGet('folder') ?? 'all';
        $files  = $folder === 'all'
            ? $this->model->getAllFiles()
            : $this->model->getFolderFiles($folder);

        return view('admin/media/index', [
            'pageTitle'      => 'Media Library',
            'files'          => $files,
            'currentFolder'  => $folder,
            'folders'        => $this->allowedFolders,
        ]);
    }

    public function upload()
    {
        $file   = $this->request->getFile('media_file');
        $folder = $this->request->getPost('folder') ?? 'general';

        if (! in_array($folder, $this->allowedFolders)) {
            $folder = 'general';
        }

        if (! $file || ! $file->isValid()) {
            return redirect()->back()->with('error', 'No valid file provided.');
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (! in_array($file->getMimeType(), $allowed)) {
            return redirect()->back()->with('error', 'Only JPEG, PNG, WebP, and GIF images are allowed.');
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('error', 'File size must not exceed 5 MB.');
        }

        $uploadPath = FCPATH . 'uploads/media/' . $folder;
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        // Get image dimensions
        $width = $height = null;
        $imgInfo = @getimagesize($uploadPath . '/' . $newName);
        if ($imgInfo) {
            [$width, $height] = $imgInfo;
        }

        $this->model->insert([
            'filename'      => $newName,
            'original_name' => $file->getClientName(),
            'folder'        => $folder,
            'mime_type'     => $file->getMimeType(),
            'file_size'     => $file->getSize(),
            'width'         => $width,
            'height'        => $height,
            'alt_text'      => $this->request->getPost('alt_text') ?? '',
            'title'         => $this->request->getPost('title') ?? '',
            'uploaded_by'   => session()->get('admin_id'),
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function delete(int $id)
    {
        $media = $this->model->find($id);
        if (! $media) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = FCPATH . 'uploads/media/' . $media['folder'] . '/' . $media['filename'];
        if (is_file($filePath)) {
            unlink($filePath);
        }

        $this->model->delete($id);
        return redirect()->back()->with('success', 'File deleted.');
    }

    /**
     * AJAX/modal endpoint for picking an image.
     * Returns HTML fragment for use inside a Bootstrap modal.
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
}
