<main id="camera-app">

    <article id="sticker-picker">
        {{::images::}}
    </article>

    <section id="main-interface">
        <div id="camera-stage">

            <video
                id="webcam"
                autoplay
                playsinline
                webkit-playsinline
                muted
                disablepictureinpicture
            ></video>

            <div id="sticker-overlay" class="small"></div>

        </div>

        <div id="photo-result">
            <canvas id="photo-canvas" class="hidden"></canvas>
            <img
                id="photo-final"
                class="hidden"
                alt="final photo"
                title="Final photo"
            >
        </div>

        <div id="camera-controls">

            <button id="btn-cancel" class="transparent">
                {{::cancel::}}
            </button>

            <button id="btn-capture" disabled>
                <!-- Imagen o dibujo de camara -->
                {{::photo::}}
            </button>

            <input type="file" id="file-input" accept=".jpg .jpeg .png" class="hidden">
            <button id="btn-upload" class="transparent">
                <!-- Imagen de subir/descargar -->
                {{::upload::}}
            </button>
        </div>
    </section>

    <form id="sticker-mod">
        <div id="mod-header">
            <h3 id="sticker-title" class="text-center"></h3>
            <button id="btn-close" class="close-x" type="button">x</button>
        </div>

        <label for="size">{{::scale::}}</label>
        <input id="size" type="range" name="size" min="0.5" max="5" step="0.1" value="1">

        <label for="rotate">{{::rotation::}}</label>
        <input id="rotate" name="rotate" type="range" min="-180" max="180" step="1" value="0">

        <div id="mod-actions">
            <button id="btn-reset" type="reset">{{::reset::}}</button>
            <button id="btn-delete" type="button">{{::delete::}}</button>
        </div>
    </form>
</main>
<aside id="preview-container">
    {{::thumbnails::}}
</aside>