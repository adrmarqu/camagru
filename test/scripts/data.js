/* Llamar iniciadores */

/* 

Estructura

body
    main
        aside
        section
            div1
            div2
            div3
        aside2
    aside3

1- Lista de stickers a escoger (aside)
2- Camara + stickers clonados (los que se mostraran en la foto final) (section,div1)
3- img final + canvas (section,div2)
4- Botones que controlan el estado y descargan o suben imagenes (section,div3)
5- Modificador de stickers (aside2)
6- Contenedor con las previews (aside3)

src/
│
├── editor.js
│
├── core/
│   ├── state.js
│   ├── dom.js
│   └── events.js
│
├── camera/
│   ├── camera.js
│   ├── capture.js
│   └── canvas.js
│
├── stickers/
│   ├── stickerGallery.js
│   ├── stickerManager.js
│   ├── stickerTransform.js
│   └── dragResizeRotate.js
│
├── ui/
│   ├── controls.js
│   ├── previews.js
│   └── modals.js
│
├── export/
│   ├── mergeImages.js
│   ├── download.js
│   └── upload.js
│
└── utils/
    ├── helpers.js
    ├── constants.js
    └── math.js


import { initCamera } from './camera/camera.js';
import { initStickerGallery } from './stickers/stickerGallery.js';
import { initControls } from './ui/controls.js';

initCamera();
initStickerGallery();
initControls();



export const state = {
    stickers: [],
    selectedSticker: null,
    capturedImage: null,
    previews: [],
    cameraActive: false
};



export const DOM = {
    video: document.querySelector('#video'),
    canvas: document.querySelector('#canvas'),
    stickerPanel: document.querySelector('#stickers'),
    previewContainer: document.querySelector('#previews')
};



core/events.js

Eventos globales.

Ejemplo:

teclado
resize
shortcuts
listeners generales



export async function initCamera() {
    const stream = await navigator.mediaDevices.getUserMedia({
        video: true
    });

    video.srcObject = stream;
}



export function takePhoto(video, canvas) {
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);
}



camera/canvas.js

Toda lógica del canvas:

dibujar imagen
renderizar stickers
fusionar capas
limpiar canvas



export function loadStickerList() {}


export function addSticker(src) {}
export function removeSticker(id) {}



stickers/stickerTransform.js

Transformaciones:

escala
rotación
opacidad
flip



stickers/dragResizeRotate.js

Solo interacciones físicas:

drag
resize
rotate

MUY importante separarlo.



btnTakePhoto.addEventListener(...)
btnDownload.addEventListener(...)



export function addPreview(image) {}


ui/modals.js

Si luego añades:

popup
confirmaciones
ajustes



export/mergeImages.js

Fusiona:

foto
stickers
overlays

Genera la imagen final.



export function downloadImage(dataUrl) {}



export/upload.js

Subir imágenes.

local
drag&drop
API
cloud


export function uuid() {}
export function clamp() {}


export const MAX_STICKERS = 20;




------------------------------------------------------------------

import {
    cameraIdleState,
    editingState,
    photoTakenState,
    finalImageState
} from './states.js';

export const STATES = {
    CAMERA_IDLE: 0,
    EDITING: 1,
    PHOTO_TAKEN: 2,
    FINAL_IMAGE: 3
};

let currentState = STATES.CAMERA_IDLE;

const stateHandlers = {
    [STATES.CAMERA_IDLE]: cameraIdleState,
    [STATES.EDITING]: editingState,
    [STATES.PHOTO_TAKEN]: photoTakenState,
    [STATES.FINAL_IMAGE]: finalImageState
};

export function renderCurrentState() {
    stateHandlers[currentState]();
}

export function nextState() {
    if(currentState < STATES.FINAL_IMAGE) {
        currentState++;
        renderCurrentState();
    }
}

export function prevState() {
    if(currentState > STATES.CAMERA_IDLE) {
        currentState--;
        renderCurrentState();
    }
}

export function cameraIdleState() {
    console.log('camera idle');
}

export function editingState() {
    console.log('editing stickers');
}

export function photoTakenState() {
    console.log('photo taken');
}

export function finalImageState() {
    console.log('final image');
}


*/