<h1>Este es el editor de fotos</h1>

<main style="border: 3px solid blue;">

    <h2>Camera</h2>

    <video id="webcam" autoplay playsinline></video>
    
    <div>
        {{::stickers::}}
    </div>

    <button id="capture" class="{{::captureBtn::}}">
        {{::image_photo::}}
    </button>

</main>

<aside>
    <h2>Previews</h2>
    <div>
        {{::thumbnails::}}
    </div>
</aside>