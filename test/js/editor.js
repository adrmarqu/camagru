import Camera from './camera.js';
import { StickerManager } from './stickerManager.js';

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
const modTitle = document.getElementById("sticker-title");

/* input to take pictures from your machine */
const fileInput = document.getElementById("file-input");

/* buttons */
const btnCapture = document.getElementById("btn-capture");
const btnCancel = document.getElementById("btn-cancel");
const btnUpload = document.getElementById("btn-upload");

/* Modificator */
const sizeMod = document.querySelector("#sticker-mod #size");
const rotMod = document.querySelector("#sticker-mod #rotate");
const delMod = document.querySelector("#sticker-mod #delete");
const reset = document.querySelector("#camera-app section");

const STATES =
{
    INITIAL: 'INITIAL',
    MANAGE_STICKERS: 'STICKER',
    GET_PHOTO: 'PHOTO',
    RESULT: 'RESULT'
};

let currentState = null;
let imgSelected = null;

const stateManage = () =>
{
    switch (currentState)
    {
        case STATES.INITIAL:
            
            stickerContainer.className = "";
            
            webcam.className = "";
            photoFinal.className = "hidden";
            stickerOverlay.innerHTML = "";
            
            stickerMod.className = "hidden";
            previewContainer.className = "";

            btnCancel.className = "hidden";
            btnCapture.disabled = true;
            btnUpload.className = "hidden";

            Camera.start(webcam);

            break;
        case STATES.MANAGE_STICKERS:

            stickerContainer.className = "";
            
            webcam.className = "";
            photoFinal.className = "hidden";
            
            stickerMod.className = "hidden";
            previewContainer.className = "";

            btnCancel.className = "";
            btnCapture.disabled = false;
            btnUpload.className = "hidden";

            break;
        case STATES.GET_PHOTO:

            stickerContainer.className = "transparent";
            
            webcam.className = "";
            photoFinal.className = "hidden";
            
            stickerMod.className = "hidden";
            previewContainer.className = "transparent";

            btnCancel.className = "";
            btnCapture.disabled = false;
            btnUpload.className = "";

            break;
        case STATES.RESULT:

            stickerContainer.className = "hidden";
            webcam.className = "hidden";
            photoFinal.className = "";
            stickerMod.className = "hidden";
            previewContainer.className = "hidden";

            btnCancel.className = "";
            btnCapture.disabled = false;
            btnUpload.className = "";

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
            else if (action === "NEXT")
            {
                saveImg();
                setState(STATES.INITIAL);
            }
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

const saveImg = () =>
{
    alert("Imagen guardada");
    return ;
};

const setModContainer = () =>
{
    if (!imgSelected)
        return ;

    stickerMod.className = "";
    previewContainer.className = "hidden";

    const n = imgSelected.dataset.stickerName;

    modTitle.innerHTML = n.split('.').shift();
    sizeMod.value = imgSelected.dataset.scale;
    rotMod.value = imgSelected.dataset.rotate;
};

btnCapture.addEventListener("click", () => handleActions("NEXT"));
btnCancel.addEventListener("click", () => handleActions("PREV"));
btnUpload.addEventListener("click", () => fileInput.click());
fileInput.addEventListener("change", getPictureFiles);

stickerList.forEach(sticker =>
{
    sticker.addEventListener("click", () => 
    {
        const clone = StickerManager.create(sticker);
        if (clone)
        {
            clone.addEventListener("click", () =>
            {
                imgSelected = clone;
                setModContainer();
            });
        }
        if (stickerOverlay.children.length === 1)
            setState(STATES.MANAGE_STICKERS);
        imgSelected = clone;
        setModContainer();
    });
});

sizeMod.addEventListener("input", () =>
{
    if (!imgSelected) return ;

    imgSelected.dataset.scale = sizeMod.value;
    StickerManager.modify(imgSelected);
});

rotMod.addEventListener("input", () =>
{
    if (!imgSelected) return ;

    imgSelected.dataset.rotate = rotMod.value;
    StickerManager.modify(imgSelected);
});

delMod.addEventListener("click", () =>
{
    if (!imgSelected)
        return ;

    imgSelected.remove();
    imgSelected = null;

    if (stickerOverlay.children.length === 0)
        setState(STATES.INITIAL);
});

webcam.addEventListener("click", () =>
{
    imgSelected = null;
    stickerMod.className = "hidden";
    previewContainer.className = "";
});

setState(STATES.INITIAL);