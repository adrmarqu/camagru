import Camera from './camera.js';
import StickerManager from './stickerManager.js';

/* Photo elements */
const webcam = document.getElementById("webcam");
const canvas = document.getElementById("photo-canvas");
const photoFinal = document.getElementById("photo-final");

/* Containers */
const stickerContainer = document.getElementById("sticker-picker");
const previewContainer = document.getElementById("preview-container");
const stickerOverlay = document.getElementById("sticker-overlay");

/* stickers */
const stickerList = document.querySelectorAll("#sticker-picker img");
const stickerMod = document.getElementById("sticker-mod");

/* input to take pictures from your machine */
const fileInput = document.getElementById("file-input");

/* buttons */
const btnCapture = document.getElementById("btn-capture");
const btnCancel = document.getElementById("btn-cancel");
const btnUpload = document.getElementById("btn-upload");

const STATES =
{
    INITIAL: 'INITIAL',
    MANAGE_STICKERS: 'STICKER',
    GET_PHOTO: 'PHOTO',
    RESULT: 'RESULT'
};

const LIMIT_STICKERS = 5;

let currentState = null;

const stateManage = () =>
{
    switch (currentState)
    {
        case STATES.INITIAL:

            webcam.className = "";
            photoFinal.className = "hidden";

            stickerContainer.className = "";
            previewContainer.className = "";
            stickerOverlay.innerHTML = "";
            stickerMod.className = "hidden";

            btnCancel.className = "transparent";
            btnUpload.className = "transparent";
            btnCapture.disabled = true;

            /* Iniciar camara */

            Camera.start(webcam);

            break;
        case STATES.MANAGE_STICKERS:

            webcam.className = "";
            photoFinal.className = "hidden";
            
            stickerContainer.className = "";
            previewContainer.className = "hidden";
            stickerMod.className = "";

            btnCancel.className = "";
            btnUpload.className = "transparent";
            btnCapture.disabled = false;

            /* Movimiento de los stickers */

            break;
        case STATES.GET_PHOTO:

            webcam.className = "";
            photoFinal.className = "hidden";

            stickerContainer.className = "transparent";
            previewContainer.className = "transparent";
            stickerMod.className = "hidden";

            btnUpload.className = "";

            break;
        case STATES.RESULT:

            webcam.className = "hidden";
            photoFinal.className = "";

            stickerContainer.className = "hidden";
            previewContainer.className = "hidden";

            btnUpload.className = "hidden";

            /* Cancelar: Mantener stickers */
            /* Subir: Dejar limpieza al estado 1 */

            break;
        default:
            currentState = STATES.INITIAL;
            console.log("Unknown error (state: " + currentState + ")");
    }
};

const setState = (newState) =>
{
    currentState = newState;
    stateManage();
};

const handleActions = async (action) =>
{
    switch (currentState)
    {
        case STATES.INITIAL:
            if (action === "NEXT") setState(STATES.MANAGE_STICKERS);
            break ;
        case STATES.MANAGE_STICKERS:
            if (action === "PREV") setState(STATES.INITIAL);
            else if (action === "NEXT") setState(STATES.GET_PHOTO);
            break ;
        case STATES.GET_PHOTO:
            if (action === "PREV") setState(STATES.MANAGE_STICKERS);
            else if (action === "NEXT")
            {
                const blob = await Camera.elementToBlob(webcam, canvas);
                const objectUrl = URL.createObjectURL(blob);
                
                photoFinal.src = objectUrl;
                URL.revokeObjectURL(objectUrl);

                setState(STATES.RESULT);
            }
            break ;
        case STATES.RESULT:
            if (action === "PREV") setState(STATES.GET_PHOTO);
            else if (action === "NEXT") setState(STATES.INITIAL);
            break ;
        default:
            currentState = STATES.INITIAL;
            console.log("Unknown error (state: " + currentState + ")");
    }
};

const getPictureFiles = () =>
{
    const file = fileInput.files[0];

    if (!file)
    {
        console.warn("No file selected");
        return;
    }
    const img = new Image();
    const objectUrl = URL.createObjectURL(file);

    img.src = objectUrl;

    img.onload = async () =>
    {
        try
        {
            const blob = await Camera.elementToBlob(img, canvas);
            const finalUrl = URL.createObjectURL(blob);
            photoFinal.src = finalUrl;

            setState(STATES.RESULT);

            URL.revokeObjectURL(objectUrl);
        }
        catch (err)
        {
            console.error("Error processing image:", err);
        }
    };

    img.onerror = () =>
    {
        console.error("Invalid image file");
        URL.revokeObjectURL(objectUrl);
    };
};

btnCapture.addEventListener("click", () => handleActions("NEXT"));
btnCancel.addEventListener("click", () => handleActions("PREV"));
btnUpload.addEventListener("click", () => fileInput.click());
fileInput.addEventListener("change", getPictureFiles);

stickerList.forEach(sticker =>
{
    sticker.addEventListener("click", () =>
    {
        if (currentState === STATES.GET_PHOTO || currentState === STATES.RESULT)
            return ;

        if (stickerOverlay.children.length < LIMIT_STICKERS)
        {
            const clone = StickerManager.createSticker(sticker);

            clone.onclick = () =>
            {
                if (currentState === STATES.GET_PHOTO || currentState === STATES.RESULT) return ;

                clone.remove();
                if (stickerOverlay.children.length === 0)
                    setState(STATES.INITIAL);
            };

            stickerOverlay.appendChild(clone);

            setState(STATES.MANAGE_STICKERS);
        }
    });
});

setState(STATES.INITIAL);