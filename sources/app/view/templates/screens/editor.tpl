<main id="camera-app">

    <!-- 1. Selección de stickers -->
    <div id="sticker-picker">
        {{::stickers::}}
    </div>

    <!-- 2. Zona cámara + overlay -->
    <div id="camera-stage">

        <video
            id="webcam"
            autoplay
            playsinline
            muted
        ></video>

        <!-- stickers superpuestos -->
        <div id="sticker-overlay"></div>

    </div>

    <!-- 3. Resultado final -->
    <div id="photo-result">
        <canvas id="photo-canvas" class="hidden"></canvas>
        <img
            id="photo-final"
            class="hidden"
            alt="final photo"
            title="Final photo"
        >
    </div>

    <!-- 4. Controles -->
    <div id="camera-controls">

        <button id="btn-cancel" class="transparent">
            Cancelar
        </button>

        <button id="btn-capture" disabled>
            Foto
        </button>

        <input type="file" id="file-input" accept=".jpg .jpeg .png" class="hidden">
        <button id="btn-upload" class="transparent">
            Subir
        </button>

    </div>

</main>

<!-- 5. Historial / thumbnails -->
<aside id="thumbnails">
    {{::thumbnails::}}
</aside>