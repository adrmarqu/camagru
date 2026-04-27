<main style="border: 3px solid blue;">

    <div id="stickers-container">{{::stickers::}}</div>

    <video id="webcam" autoplay playsinline muted></video>
    <canvas id="canvas" class="hidden"></canvas>
    <img id="final-img" class="hidden" alt="final_photo" title="Final photo">

    <div id="dinamic-stickers-container">

    </div>
    
    <!-- Crear imagenes por js -->

    <div id="btn-container">
        <button id="btn-cancel" class="transparent"></button>
        <button id="btn-send" disabled></button>
        <button id="btn-upload" class="transparent"></button>
    </div>

</main>

<aside>
    {{::thumbnails::}}
</aside>

    <!-- Estado 1 - Conseguir stickers -->
    <div>
        <div>
            stickers
        </div>
        <div>
            <video src=""></video>
            <button>desactivado</button>
        </div>
    </div>

    <!-- Estado 2 - Finalizar eleccion de stickers -->
    <div>
        <div>
            stickers
        </div>
        <div>
            <video src=""></video>
            <img src="" alt="">
            <button>activado</button>
        </div>
    </div>

    <!-- Estado 3 - Conseguir la imagen -->
    <div>
        <div>
            <video src=""></video>
            <img src="" alt="">
            <div>
                <button>cancelar</button>
                <button>capturar</button>
                <button>archivos</button>
            </div>
        </div>
    </div>

    <!-- Estado 4 - Confirmar imagen fusionada -->
    <div>
        <div>
            <img src="" alt="">
            <button>cancelar</button>
            <button>enviar</button>
        </div>
    </div>