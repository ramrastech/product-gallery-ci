<?php
/**
 * Media Library Picker — HTML fragment loaded inside a Bootstrap modal.
 * No DOCTYPE/html/body tags — just content.
 * All interaction is handled by event delegation in the parent page's JS.
 */
?>
<div class="d-flex align-items-center justify-content-between gap-2 mb-3 flex-wrap">
    <div class="d-flex gap-1 flex-wrap" id="pickerFolderTabs">
        <button type="button" class="btn btn-xs picker-folder <?= $currentFolder === 'all' ? 'btn-primary' : 'btn-outline-secondary' ?>"
                style="font-size:.75rem;padding:.2rem .55rem;" data-folder="all">All</button>
        <?php foreach ($folders as $f): ?>
        <button type="button" class="btn btn-xs picker-folder <?= $currentFolder === $f ? 'btn-primary' : 'btn-outline-secondary' ?>"
                style="font-size:.75rem;padding:.2rem .55rem;" data-folder="<?= esc($f) ?>">
            <?= esc(ucfirst($f)) ?>
        </button>
        <?php endforeach; ?>
    </div>
    <label class="btn btn-sm btn-outline-secondary mb-0" style="cursor:pointer;font-size:.75rem;" title="Upload a new image to the library">
        <i class="bi bi-upload me-1"></i> Upload to Library
        <input type="file" id="pickerFileInput" accept="image/jpeg,image/png,image/webp,image/gif" style="display:none;">
    </label>
</div>

<div id="pickerUploadProgress" style="display:none;" class="mb-2">
    <div class="progress" style="height:3px;">
        <div class="progress-bar bg-primary" id="pickerProgressBar" style="width:0%;transition:width .2s;"></div>
    </div>
    <small class="text-muted" id="pickerUploadMsg" style="font-size:.7rem;"></small>
</div>

<?php if (! empty($files)): ?>
<div class="row g-2" id="pickerGrid">
    <?php foreach ($files as $file):
        $variants  = json_decode($file['variants'] ?? '{}', true) ?: [];
        $thumbFile = $variants['th']['file'] ?? $variants['sm']['file'] ?? $file['filename'];
        $thumbUrl  = '/uploads/media/' . $file['folder'] . '/' . $thumbFile;
        // For OG folder, use the JPEG copy if available (WhatsApp/social crawlers need JPEG)
        $ogJpeg     = $variants['og_jpeg']['file'] ?? null;
        $primaryUrl = '/uploads/media/' . $file['folder'] . '/' . ($ogJpeg ?? $file['filename']);
        $imgFormat  = $ogJpeg ? 'JPEG' : 'WebP';
    ?>
    <div class="col-4 col-sm-3 col-md-2">
        <div class="picker-item" data-url="<?= esc($primaryUrl) ?>" data-alt="<?= esc($file['alt_text'] ?? '') ?>"
             data-name="<?= esc($file['original_name'] ?? $file['filename']) ?>"
             style="cursor:pointer; border:2px solid var(--card-border); border-radius:6px; overflow:hidden; transition:border-color .15s;">
            <img src="<?= esc($thumbUrl) ?>" alt="<?= esc($file['alt_text'] ?? '') ?>"
                 style="width:100%; height:72px; object-fit:cover; display:block;" loading="lazy">
            <div style="font-size:.6rem; padding:.2rem .35rem; background:var(--card-bg);">
                <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; color:var(--text-muted);">
                    <?= esc($file['original_name'] ?? $file['filename']) ?>
                </div>
                <span style="display:inline-block;background:rgba(99,102,241,.15);color:var(--accent);font-size:.55rem;padding:.1rem .3rem;border-radius:3px;font-weight:600;line-height:1.4;"><?= $imgFormat ?></span>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center text-muted py-5" id="pickerGrid">
    <i class="bi bi-images d-block mb-2" style="font-size:2rem;"></i>
    No images in this folder. Upload one above.
</div>
<?php endif; ?>
