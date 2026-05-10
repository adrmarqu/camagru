const DOM =
{
    /* Photo elements */
    webcam: document.getElementById("webcam"),
    canvas: document.getElementById("photo-canvas"),
    photoFinal: document.getElementById("photo-final"),

    /* Containers */
    stickerContainer: document.getElementById("sticker-picker"),
    previewContainer: document.getElementById("preview-container"),
    stickerOverlay: document.getElementById("sticker-overlay"),

    /* stickers */
    stickerList: document.querySelectorAll("#sticker-picker img"),

    /* input to take pictures from your machine */
    fileInput: document.getElementById("file-input"),

    /* Sticker modificator */
    stickerMod: document.getElementById("sticker-mod"),
    modTitle: document.getElementById("sticker-title"),
    sizeMod: document.querySelector("#sticker-mod #size"),
    rotMod: document.querySelector("#sticker-mod #rotate"),
    btnClose: document.getElementById("btn-close"),
    btnReset: document.getElementById("btn-reset"),
    btnDelete: document.getElementById("btn-delete"),

    /* buttons */
    btnCapture: document.getElementById("btn-capture"),
    btnCancel: document.getElementById("btn-cancel"),
    btnUpload: document.getElementById("btn-upload")
};

export default DOM;