/* Photo elements */
const webcam = document.getElementById("webcam");
const canvas = document.getElementById("photo-canvas");
const photoFinal = document.getElementById("photo-final");

/* Containers */
const stickerContainer = document.getElementById("sticker-picker");
const previewContainer = document.getElementById("preview-container");
const stickerOverlay = document.getElementById("sticker-overlay");

/* stickers list */
const stickerList = document.querySelectorAll("#sticker-picker img");

/* input to take pictures from your machine */
const fileInput = document.getElementById("file-input");

/* buttons */
const btnCapture = document.getElementById("btn-capture");
const btnCancel = document.getElementById("btn-cancel");
const btnUpload = document.getElementById("btn-upload");

const STAGES =
{
    INITIAL: 'INITIAL',
    MANAGE_STICKERS: 'STICKER',
    GET_PHOTO: 'PHOTO',
    RESULT: 'RESULT'
};

let currentState;

const stateManage = () =>
{
    switch (currentState)
    {
        case STAGES.INITIAL:

            webcam.className = "";
            photoFinal.className = "hidden";

            stickerContainer.className = "";
            previewContainer.className = "";
            stickerOverlay.innerHTML = "";

            btnCancel.className = "transparent";
            btnUpload.className = "transparent";
            btnCapture.disabled = true;

            break;
        case STAGES.MANAGE_STICKERS:

            webcam.className = "";
            photoFinal.className = "hidden";
            
            stickerContainer.className = "";
            previewContainer.className = "";

            btnCancel.className = "";
            btnUpload.className = "transparent";
            btnCapture.disabled = false;

            break;
        case STAGES.GET_PHOTO:

            webcam.className = "";
            photoFinal.className = "hidden";

            stickerContainer.className = "transparent";
            previewContainer.className = "transparent";

            btnUpload.className = "";

            break;
        case STAGES.RESULT:

            webcam.className = "hidden";
            photoFinal.className = "";

            stickerContainer.className = "hidden";
            previewContainer.className = "hidden";

            btnUpload.className = "hidden";

            /* Cancelar: Mantener stickers */
            /* Subir: Dejar limpieza al estado 1 */

            break;
        default:
            state = STAGES.INITIAL;
            console.log("Unknown error (state: " + state + ")");
    }
};

const setStage = (newState) =>
{
    currentState = newState;
    stateManage();
};

setStage(STAGES.INITIAL);






const sentToServer = (img) =>
{
    const formData = new FormData();

    /* Add photo */
    formData.append('base', img, 'capture.jpg');

    /* Stickers */

    const stickersData = [];
    const stickersInDOM = document.querySelectorAll(".sticker-on-webcam");

    const scaleX = webcam.videoWidth / webcam.clientWidth;
    const scaleY = webcam.videoHeight / webcam.clientHeight;

    stickersInDOM.forEach(s =>
    {
        stickersData.push(
        {
            name: s.dataset.stickerName,
            x: parseFloat(s.style.left) * scaleX,
            y: parseFloat(s.style.top) * scaleY,
            width: s.clientWidth * scaleX,
            height: s.clientHeight * scaleY
        });
    });

    /* Add stickers */
    formData.append('stickers', JSON.stringify(stickersData));

    /* Send */

    fetch("mi_php",
    {
        method: 'POST',
        body: formData
    })
    .then(res => res.blob())
    .then(final =>
    {
        photoFinal.src = URL.createObjectURL(final);
        photoFinal.classList.remove("hidden");
        webcam.classList.add("hidden");
    })
    .catch(e =>
    {
        console.log("Error:", e);
    });
};

stickerList.forEach(img =>
{
    img.addEventListener("click", () => cloneSticker(img));
});

btnCapture.addEventListener("click", setImage);

startCamera();