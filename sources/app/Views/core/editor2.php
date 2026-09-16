<div class="editor-container">

    <!-- Mobile Top Navigation: Toggles for Stickers & Previews Drawers -->
    <nav class="editor-mobile-nav" aria-label="Navegación del editor móvil">
        <button type="button" id="btn-toggle-stickers" class="btn-toggle-panel" aria-controls="stickers-panel" aria-expanded="false">
            <span>Stickers</span>
        </button>
        <button type="button" id="btn-toggle-aside" class="btn-toggle-panel" aria-controls="editor-aside" aria-expanded="false">
            <span>Preview</span>
        </button>
    </nav>

    <div class="editor-layout">
        <!-- Left Panel: Stickers Gallery & Sticker Modifier -->
        <section class="editor-stickers-panel" id="stickers-panel">
            <!-- Stickers Selection & Limit Counter -->
            <div class="stickers-section">
                <header class="stickers-header">
                    <div class="stickers-counter" id="stickers-counter" title="Stickers usados / Stickers máximos permitidos">
                        <span id="stickers-count">0</span> / <span id="stickers-max">10</span>
                    </div>
                    <h2>Stickers</h2>
                </header>

                <div class="stickers-list" id="stickers-list" role="listbox" aria-label="Lista de stickers">
                    <?php
                    $stickersDir = PUBLIC_PATH . '/assets/stickers';
                    $stickers = is_dir($stickersDir) ? (glob($stickersDir . '/*.{png,webp,svg,jpg,jpeg}', GLOB_BRACE) ?: []) : [];
                    ?>
                    <?php if (!empty($stickers)): ?>
                        <?php foreach ($stickers as $sticker): ?>
                            <?php $filename = basename($sticker); ?>
                            <button type="button" class="sticker-item" data-sticker-name="<?= htmlspecialchars($filename) ?>" data-sticker-src="<?= URL_ASSETS . '/stickers/' . htmlspecialchars($filename) ?>" role="option" aria-selected="false">
                                <img src="<?= URL_ASSETS . '/stickers/' . htmlspecialchars($filename) ?>" alt="<?= htmlspecialchars(pathinfo($filename, PATHINFO_FILENAME)) ?>" loading="lazy">
                            </button>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="stickers-empty" id="stickers-empty">No hay stickers disponibles</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sticker Modifier Panel -->
            <div class="sticker-modifier" id="sticker-modifier">
                <h3 id="sticker-modifier-title" class="sticker-modifier-title">Modificar sticker</h3>
                
                <div class="modifier-controls">
                    <!-- Size -->
                    <div class="control-group">
                        <label for="sticker-size">Tamaño</label>
                        <input type="range" id="sticker-size" name="sticker-size" min="20" max="300" value="100" disabled>
                    </div>

                    <!-- Rotation -->
                    <div class="control-group">
                        <label for="sticker-rotation">Rotación</label>
                        <input type="range" id="sticker-rotation" name="sticker-rotation" min="0" max="360" value="0" disabled>
                    </div>

                    <!-- Delete Sticker Button -->
                    <div class="control-group">
                        <button type="button" id="btn-delete-sticker" class="btn-delete-sticker" disabled>
                            Eliminar sticker
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Center: Camera / Viewport & Actions -->
        <main class="editor-main">
            <!-- Camera Viewport Area -->
            <div class="webcam-wrapper" id="webcam-wrapper">
                <video id="webcam-video" autoplay playsinline muted></video>
                <canvas id="stickers-canvas" class="stickers-canvas"></canvas>
                <canvas id="photo-canvas" class="photo-canvas" hidden></canvas>
                
                <!-- Uploaded image preview when file is loaded instead of live video -->
                <img id="uploaded-preview" class="uploaded-preview hidden" alt="Vista previa de imagen subida">
            </div>

            <!-- Editor Action Buttons -->
            <div class="editor-actions">
                <!-- Clear Stickers (Diamond) -->
                <button type="button" id="btn-clear-stickers" class="btn-action btn-diamond" title="Limpiar stickers" aria-label="Limpiar stickers">
                    <span class="btn-icon">🧹</span>
                    <span class="btn-label">Limpiar</span>
                </button>

                <!-- Capture Photo (Circle) -->
                <button type="button" id="btn-capture-photo" class="btn-action btn-circle" title="Capturar imagen" aria-label="Capturar imagen">
                    <span class="btn-shutter-inner"></span>
                </button>

                <!-- Upload Image (Diamond) -->
                <button type="button" id="btn-upload-trigger" class="btn-action btn-diamond" title="Subir imagen" aria-label="Subir imagen">
                    <span class="btn-icon">📁</span>
                    <span class="btn-label">Subir</span>
                </button>
                <input type="file" id="input-file-upload" name="image" accept="image/png, image/jpeg, image/webp" hidden>
            </div>
        </main>

        <!-- Right Side: Thumbnails Aside -->
        <aside class="editor-aside" id="editor-aside">
            <section class="thumbnails-section">
                <header class="thumbnails-header">
                    <h2>Thumbnails</h2>
                </header>

                <div class="thumbnails-list" id="thumbnails-list">
                    <!-- Las previews de las fotos capturadas/subidas se renderizan aquí -->
                    <p class="thumbnails-empty" id="thumbnails-empty">No hay fotos capturadas aún</p>
                </div>
            </section>
        </aside>
    </div>

    <!-- Modal: Foto en grande -->
    <dialog class="photo-modal" id="photo-modal">
        <div class="modal-content">
            <header class="modal-header">
                <button type="button" id="btn-close-modal" class="btn-close-modal" aria-label="Cerrar modal">✕</button>
                <div class="modal-likes" id="modal-likes">
                    <span class="likes-icon">❤️</span>
                    <span id="modal-likes-count" class="likes-count">0</span>
                    <span class="likes-label">Likes</span>
                </div>
            </header>

            <div class="modal-body">
                <img id="modal-photo-img" class="modal-photo-img" src="" alt="Foto en grande">
            </div>

            <footer class="modal-footer">
                <!-- Download Button (Diamond) -->
                <button type="button" id="btn-download-photo" class="btn-action btn-diamond" title="Descargar foto" aria-label="Descargar foto">
                    <span class="btn-icon">⬇️</span>
                    <span class="btn-label">Descargar</span>
                </button>

                <!-- Delete Button (Diamond) -->
                <button type="button" id="btn-delete-photo" class="btn-action btn-diamond" title="Eliminar foto" aria-label="Eliminar foto">
                    <span class="btn-icon">🗑️</span>
                    <span class="btn-label">Eliminar</span>
                </button>
            </footer>
        </div>
    </dialog>
</div>