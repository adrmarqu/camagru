import Modifier from './modify.js';
import Sticker from './sticker.js';
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



/* 

Subir foto

Boton de captura

Enviar al backend, fusionar imagen, subir imagen

Aside -> thumbnail

Modal -> big thumbnail


*/