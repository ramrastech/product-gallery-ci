<?php
/**
 * @project    Product Gallery — OEM Leather & Fashion Accessories Platform
 * @copyright  © 2026 Ramras Technologies. All rights reserved.
 */
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- Upload Form -->
<div class="card mb-4">
    <div class="card-header py-3 px-4"><h6 class="mb-0">Upload New Media</h6></div>
    <div class="card-body p-4">
        <form action="/admin/media/upload" method="post" enctype="multipart/form-data" class="row g-3">
            <?= csrf_field() ?>
            <div class="col-md-4">
                <label class="form-label">File <small class="text-muted">(JPEG, PNG, WebP, GIF — max 5 MB)</small></label>
                <input type="file" name="media_file" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Folder</label>
                <select name="folder" class="form-select">
                    <?php foreach ($folders as $f): ?>
                    <option value="<?= esc($f) ?>" <?= $currentFolder === $f ? 'selected' : '' ?>><?= esc(ucfirst($f)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Alt Text</label>
                <input type="text" name="alt_text" class="form-control" placeholder="Describe the image...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Title <small class="text-muted">(optional)</small></label>
                <input type="text" name="title" class="form-control" placeholder="Image title...">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-1"></i>Upload
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Folder Filter -->
<div class="d-flex gap-2 mb-4 flex-wrap">
    <a href="/admin/media" class="btn btn-sm <?= $currentFolder === 'all' ? 'btn-primary' : 'btn-outline-secondary' ?>">All</a>
    <?php foreach ($folders as $f): ?>
    <a href="/admin/media?folder=<?= esc($f) ?>" class="btn btn-sm <?= $currentFolder === $f ? 'btn-primary' : 'btn-outline-secondary' ?>">
        <?= esc(ucfirst($f)) ?>
    </a>
    <?php endforeach; ?>
</div>

<!-- Media Grid -->
<?php if (! empty($files)): ?>
<div class="row g-3">
    <?php foreach ($files as $file): ?>
    <?php $url = '/uploads/media/' . $file['folder'] . '/' . $file['filename']; ?>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="card h-100" style="border-color: var(--card-border);">
            <div style="height:120px;overflow:hidden;border-radius:6px 6px 0 0;background:#0f172a;">
                <img src="<?= esc($url) ?>" alt="<?= esc($file['alt_text'] ?? $file['filename']) ?>"
                     style="width:100%;height:100%;object-fit:cover;" loading="lazy">
            </div>
            <div class="card-body p-2">
                <div class="small text-truncate" title="<?= esc($file['original_name'] ?? $file['filename']) ?>" style="font-size:.72rem;">
                    <?= esc($file['original_name'] ?? $file['filename']) ?>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-1">
                    <span class="badge" style="background:#1e293b;color:#64748b;font-size:.65rem;"><?= esc($file['folder']) ?></span>
                    <span style="font-size:.65rem;color:var(--text-muted);">
                        <?= $file['file_size'] ? round($file['file_size']/1024) . ' KB' : '' ?>
                    </span>
                </div>
                <div class="d-flex gap-1 mt-2">
                    <button type="button" class="btn btn-xs btn-outline-secondary flex-grow-1"
                            onclick="copyUrl('<?= esc($url) ?>')" title="Copy URL">
                        <i class="bi bi-clipboard" style="font-size:.75rem;"></i>
                    </button>
                    <form action="/admin/media/delete/<?= (int) $file['id'] ?>" method="post" onsubmit="return confirm('Delete this file?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-xs btn-outline-danger" title="Delete">
                            <i class="bi bi-trash" style="font-size:.75rem;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center py-5 text-muted">
    <i class="bi bi-image display-3 d-block mb-3" style="opacity:.3;"></i>
    No files in this folder yet.
</div>
<?php endif; ?>

<?= $this->section('styles') ?>
<style>
.btn-xs { padding: .2rem .4rem; font-size: .72rem; }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function copyUrl(url) {
    var base = window.location.origin;
    navigator.clipboard.writeText(base + url).then(function() {
        alert('URL copied: ' + base + url);
    });
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
