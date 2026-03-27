<?php
/**
 * Media Library Picker — used inside Bootstrap modal
 * Called via AJAX: /admin/media/picker?folder=general
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { margin:0; padding:1rem; background:#0f172a; color:#f1f5f9; font-family:system-ui,sans-serif; }
.grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(100px,1fr)); gap:.5rem; }
.item { cursor:pointer; border:2px solid transparent; border-radius:6px; overflow:hidden; transition:border-color .15s; }
.item:hover { border-color:#6366f1; }
.item img { width:100%; height:80px; object-fit:cover; display:block; }
.item .label { font-size:.65rem; padding:.2rem .3rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; background:#1e293b; }
.folder-tabs { display:flex; gap:.5rem; flex-wrap:wrap; margin-bottom:1rem; }
.folder-tab { padding:.25rem .6rem; font-size:.75rem; border:1px solid #334155; border-radius:4px; color:#94a3b8; cursor:pointer; background:transparent; }
.folder-tab.active { background:#6366f1; color:#fff; border-color:#6366f1; }
.empty { text-align:center; color:#64748b; padding:2rem; }
</style>
</head>
<body>
<div class="folder-tabs">
    <button class="folder-tab <?= $currentFolder === 'all' ? 'active' : '' ?>"
            onclick="window.location='/admin/media/picker?folder=all'">All</button>
    <?php foreach ($folders as $f): ?>
    <button class="folder-tab <?= $currentFolder === $f ? 'active' : '' ?>"
            onclick="window.location='/admin/media/picker?folder=<?= esc($f) ?>'">
        <?= esc(ucfirst($f)) ?>
    </button>
    <?php endforeach; ?>
</div>

<?php if (! empty($files)): ?>
<div class="grid">
    <?php foreach ($files as $file): ?>
    <?php $url = '/uploads/media/' . $file['folder'] . '/' . $file['filename']; ?>
    <div class="item" onclick="selectMedia(<?= (int) $file['id'] ?>, '<?= esc($url) ?>', '<?= esc($file['alt_text'] ?? '') ?>')">
        <img src="<?= esc($url) ?>" alt="<?= esc($file['alt_text'] ?? $file['filename']) ?>" loading="lazy">
        <div class="label"><?= esc($file['original_name'] ?? $file['filename']) ?></div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="empty">No images found. <a href="/admin/media" target="_blank" style="color:#6366f1;">Upload some.</a></div>
<?php endif; ?>

<script>
function selectMedia(id, url, alt) {
    // Post message back to parent window
    if (window.opener) {
        window.opener.postMessage({ type: 'media_selected', id: id, url: url, alt: alt }, '*');
        window.close();
    } else if (window.parent !== window) {
        window.parent.postMessage({ type: 'media_selected', id: id, url: url, alt: alt }, '*');
    }
}
</script>
</body>
</html>
