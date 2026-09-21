import Modifier from './modify.js';
import Sticker from './sticker.js';
import Thumbnail from './thumbnail.js';
import Webcam from './webcam.js';

/* Counter */
const nStickers = document.getElementById("nS");
const maxStickers = 10;

/* Sticker containers */
const stickerList = document.querySelectorAll(".sticker");
const stickerDest = document.getElementById("sticker-selected");

/* Delete sticker */
const delSticker = document.getElementById("mod-del");

/* Webcam buttons */
const delAll = document.getElementById("btn-del-all");
const capture = document.getElementById("btn-capture");
const upload = document.getElementById("btn-upload");

/* Canvas */
const canvas = document.getElementById("photo-canvas");

/* Translations */
const currentLang = document.documentElement.lang || 'en';

const i18n = {
    es: {
        noStickers: "Debes seleccionar al menos un sticker antes de guardar.",
        tooLarge: "La imagen es demasiado grande para el servidor.",
        invalidResponse: "Respuesta inválida del servidor.",
        processError: "Error al procesar la imagen.",
        saveSuccess: "¡Foto guardada con éxito!",
        uploadError: "Error al subir la imagen.",
        deleteSuccess: "Foto eliminada con éxito.",
        deleteError: "Error al eliminar la foto."
    },
    ca: {
        noStickers: "Has de seleccionar com a mínim un adhesiu abans de desar.",
        tooLarge: "La imatge és massa gran per al servidor.",
        invalidResponse: "Resposta no vàlida del servidor.",
        processError: "Error en processar la imatge.",
        saveSuccess: "Foto desada amb èxit!",
        uploadError: "Error en pujar la imatge.",
        deleteSuccess: "Foto eliminada amb èxit.",
        deleteError: "Error en eliminar la foto."
    },
    en: {
        noStickers: "You must select at least one sticker before saving.",
        tooLarge: "The image is too large for the server.",
        invalidResponse: "Invalid server response.",
        processError: "Error processing the image.",
        saveSuccess: "Photo saved successfully!",
        uploadError: "Error uploading the image.",
        deleteSuccess: "Photo deleted successfully.",
        deleteError: "Error deleting the photo."
    }
};

const t = (key) => (i18n[currentLang] || i18n.en)[key] || key;

/* Feedback message */
const editorMsg = document.getElementById("editor-msg");
let msgTimeout = null;

const showMessage = (text, isError = false) =>
{
    if (!editorMsg) return ;

    if (msgTimeout) clearTimeout(msgTimeout);

    editorMsg.textContent = text;
    editorMsg.className = `editor-msg ${isError ? 'error' : 'success'}`;

    msgTimeout = setTimeout(() =>
    {
        editorMsg.textContent = "";
        editorMsg.className = "editor-msg hidden";
    }, 4000);
};

let stickers = [];

Webcam.start();

const addSticker = (stick) =>
{
    if (stickerDest.children.length >= maxStickers) return ;

    const newSticker = document.createElement("img");
    newSticker.src = stick.currentTarget.src;

    const name = stick.currentTarget.dataset.sticker;
    const st = new Sticker(name, newSticker);
    stickers.push(st);

    Modifier.set(st);
    newSticker.addEventListener("pointerdown", () => Modifier.set(st));
    stickerDest.appendChild(newSticker);

    nStickers.textContent = stickerDest.children.length;
    setButtons();
};

const setButtons = () =>
{
    const isEmpty = stickerDest.children.length === 0;
    delAll.disabled = isEmpty;
    capture.disabled = isEmpty;
    upload.disabled = isEmpty;
};

const deleteOneSticker = () => 
{
    Modifier.delete(stickers);
    nStickers.textContent = stickerDest.children.length;
    setButtons();
};

const deleteStickers = () =>
{
    stickers = [];
    nStickers.textContent = 0;
    stickerDest.innerHTML = "";
    Modifier.clean();
    setButtons();
}

const takePhoto = () =>
{
    const image = Webcam.capture(canvas);
    if (!image) return ;

    sendPhotoBackend(image);
};

const uploadPhoto = () =>
{
    const input = document.createElement("input");
    input.type = "file";
    input.accept = "image/png, image/jpeg, image/jpg, image/webp, image/gif, image/avif, image/bmp";

    input.addEventListener("change", () =>
    {
        const file = input.files?.[0];
        if (!file) return ;

        if (!file.type.startsWith("image/")) return ;

        const reader = new FileReader();
        reader.onload = (e) =>
        {
            const image = e.target?.result;
            if (!image) return ;

            sendPhotoBackend(image);
        };
        reader.readAsDataURL(file);
    });

    input.click();
};

const sendPhotoBackend = async (image) =>
{
    if (!image) return ;

    if (stickers.length === 0)
    {
        showMessage(t('noStickers'), true);
        return ;
    }

    capture.disabled = true;
    upload.disabled = true;

    try
    {
        const payload =
        {
            image: image,
            stickers: stickers.map(st => st.toJson()),
            stage:
            {
                width: stickerDest.clientWidth,
                height: stickerDest.clientHeight
            }
        };

        const response = await fetch("/api/upload.php",
        {
            method: 'POST',
            headers:
            {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });

        let data;
        const text = await response.text();
        try
        {
            data = JSON.parse(text);
        }
        catch (_)
        {
            if (response.status === 413)
                throw new Error(t('tooLarge'));
            throw new Error(t('invalidResponse'));
        }

        if (!response.ok || !data.success)
            throw new Error(data.message || t('processError'));

        Thumbnail.add(data.src);
        deleteStickers();
        showMessage(data.message || t('saveSuccess'), false);
    }
    catch (error)
    {
        console.error("Error upload:", error.message || error);
        showMessage(error.message || t('uploadError'), true);
    }
    finally
    {
        setButtons();
    }
};

setButtons();

stickerList.forEach(st => st.addEventListener("click", addSticker));
delSticker.addEventListener("click", deleteOneSticker);
delAll.addEventListener("click", deleteStickers);

/* Deselect when clicking outside */
document.addEventListener("pointerdown", (e) => {
    if (Modifier.isModifierElement(e.target)) return ;
    if (e.target.closest("#sticker-selected")) return ;
    if (e.target.closest(".sticker")) return ;

    Modifier.clean();
});

capture.addEventListener("click", takePhoto);
upload.addEventListener("click", uploadPhoto);

Thumbnail.init({ showMessage, t });


/* 

Subir foto

Boton de captura

Enviar al backend, fusionar imagen, subir imagen

Aside -> thumbnail

Modal -> big thumbnail


*/