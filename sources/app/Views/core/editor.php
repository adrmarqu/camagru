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

<main>
    <!-- Stickers -->
    <section>
        <div>
            <!-- Stickers list -->
            <header>
                <span id="nS">0</span> / <span id="maxS">10</span>
            </header>
            <ul>
                <?php if (!empty($stickers)): foreach($stickers as $st): ?>
                <li>
                    <img src="<?php echo $stickerFolder . basename($st) . '?v=' . filemtime($st); ?>" alt="Sticker" class="preview sticker" data-sticker="<?= ViewHelper::name(basename($st)) ?>">
                </li>
                <?php endforeach; endif; ?>
            </ul>
        </div>
        <div>
            <h3 id="mod-title"></h3>
            <div>
                <label for="size"><?= Lang::t('editor.size') ?></label>
                <input id="mod-size" type="range" min="0.3" max="2.5" step="0.05" value="1">
            </div>
            <div>
                <label for="rotate"><?= Lang::t('editor.rotate') ?></label>
                <input id="mod-rot" type="range" min="-180" max="180" step="1" value="0">
            </div>
            <button id="mod-del"><?= Lang::t('btn.sticker') ?></button>
        </div>
    </section>
    <section>
        <!-- Webcam & Sticker Overlay Stage -->
        <div class="camera-stage">
            <video id="webcam-video" autoplay playsinline muted></video>
            <div id="sticker-selected"></div>
            <canvas id="stickers-canvas" class="stickers-canvas" hidden></canvas>
            <canvas id="photo-canvas" hidden></canvas>
        </div>
        <!-- Buttons -->
        <div>
            <button id="btn-del-all">
                <img src="/assets/trash.webp" alt="Trash" class="preview">
            </button>
            <button id="btn-capture">Captura</button>
            <button id="btn-upload">
                <img src="/assets/upload.webp" alt="Upload" class="preview">
            </button>
        </div>
        
    </section>
</main>
<aside>
    <section>
        <!-- Thumbnails -->
        <ul>
            <?php if (!empty($thumbnails)): foreach($thumbnails as $tn): ?>
            <li>
                <img src="<?php echo $previewFolder . basename($tn); ?>" alt="Thumbnail" class="preview">
            </li>
            <?php endforeach; endif; ?>
        </ul>
    </section>
    <dialog>
        <!-- Preview -->
        <div>
            <img src="" alt="Preview">
        </div>
        <footer>
            <button><?= Lang::t('btn.download') ?></button>
            <button><?= Lang::t('btn.thumbnail') ?></button>
        </footer>
    </dialog>
</aside>