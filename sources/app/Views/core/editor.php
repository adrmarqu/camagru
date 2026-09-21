<?php

// Path to glob
$stickerDir = PUBLIC_PATH . '/assets/stickers/';
$folderName = $_SESSION['user']['folder'] ?? '';
$thumbnailDir = PUBLIC_PATH . "/uploads/$folderName/media/";

// Path to frontend
$stickerFolder = URL_ASSETS . '/stickers/';
$previewFolder = URL_UPLOAD . "/$folderName/media/";

// Stickers
$stickers = glob($stickerDir . "*.webp") ?? [];
$thumbnails = glob($thumbnailDir . "*.webp") ?? [];

?>

<div class="editor-container">
    <div class="editor-main-col">
        <!-- Left Panel: Stickers & Modifier -->
        <section class="editor-panel card stickers-panel">
            <div class="stickers-box">
                <!-- Stickers list -->
                <header class="panel-header">
                    <h3><?= Lang::t('header.editor') ?? 'Stickers' ?></h3>
                    <div class="sticker-counter">
                        <span id="nS">0</span> / <span id="maxS">10</span>
                    </div>
                </header>
                <ul class="stickers-grid">
                    <?php if (!empty($stickers)): foreach($stickers as $st): ?>
                    <li>
                        <img src="<?php echo $stickerFolder . basename($st) . '?v=' . filemtime($st); ?>" alt="Sticker" class="preview sticker" data-sticker="<?= ViewHelper::name(basename($st)) ?>">
                    </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>

            <hr>

            <!-- Modifier Controls -->
            <div class="modifier-box">
                <h4 id="mod-title" class="modifier-title"></h4>
                <div class="modifier-control">
                    <div class="control-header">
                        <label for="mod-size"><?= Lang::t('editor.size') ?></label>
                    </div>
                    <input id="mod-size" type="range" min="0.3" max="2.5" step="0.05" value="1">
                </div>
                <div class="modifier-control">
                    <div class="control-header">
                        <label for="mod-rot"><?= Lang::t('editor.rotate') ?></label>
                    </div>
                    <input id="mod-rot" type="range" min="-180" max="180" step="1" value="0">
                </div>
                <button id="mod-del" class="btn-danger btn-sm" disabled><?= Lang::t('btn.sticker') ?></button>
            </div>
        </section>

        <!-- Center Panel: Camera Stage & Main Actions -->
        <section class="editor-panel card camera-panel">
            <!-- Webcam & Sticker Overlay Stage -->
            <div class="camera-stage">
                <video id="webcam-video" autoplay playsinline muted></video>
                <div id="sticker-selected"></div>
                <canvas id="stickers-canvas" class="stickers-canvas" hidden></canvas>
                <canvas id="photo-canvas" hidden></canvas>
            </div>

            <!-- Status Message / Feedback -->
            <div id="editor-msg" class="editor-msg hidden"></div>

            <!-- Buttons -->
            <div class="camera-actions">
                <button id="btn-del-all" class="btn-action btn-trash" title="Limpiar todo" disabled>
                    <img src="/assets/trash.webp" alt="Trash" class="action-icon">
                </button>
                <button id="btn-capture" class="btn-capture" disabled>
                    <span><?= Lang::t('btn.capture') ?? 'Captura' ?></span>
                </button>
                <button id="btn-upload" class="btn-action btn-upload-icon" title="Subir foto" disabled>
                    <img src="/assets/upload.webp" alt="Upload" class="action-icon">
                </button>
            </div>
        </section>
    </div>

    <!-- Right Panel: Thumbnails Side List -->
    <aside class="editor-aside-col card thumbnails-panel">
        <header class="panel-header">
            <h3><?= Lang::t('header.private') ?? 'Fotos' ?></h3>
        </header>
        <section class="thumbnails-scroll">
            <ul id="thumbnail-list" class="thumbnails-grid">
                <?php if (!empty($thumbnails)): foreach($thumbnails as $tn): ?>
                <li class="thumbnail-item">
                    <img src="<?php echo $previewFolder . basename($tn); ?>" alt="Thumbnail" class="preview">
                    <button type="button" class="thumbnail-del-btn" title="Eliminar" aria-label="Eliminar">&times;</button>
                </li>
                <?php endforeach; endif; ?>
            </ul>
        </section>
        <dialog id="preview-dialog" class="editor-dialog">
            <button type="button" class="dialog-close-btn" id="dialog-close" title="Cerrar" aria-label="Cerrar">&times;</button>
            <div class="dialog-content">
                <img src="" alt="Preview" id="dialog-img">
            </div>
            <footer class="dialog-footer">
                <button type="button" class="btn-secondary" id="dialog-download"><?= Lang::t('btn.download') ?? 'Descargar' ?></button>
                <button type="button" class="btn-danger" id="dialog-delete"><?= Lang::t('btn.thumbnail') ?? 'Eliminar' ?></button>
            </footer>
        </dialog>
    </aside>
</div>