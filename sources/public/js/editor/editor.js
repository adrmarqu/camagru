import Modifier from './modify.js';
import Sticker from './sticker.js';

/* Counter */
const nStickers = document.getElementById("nS");
const maxStickers = 10;

/* Sticker containers */
const stickerList = document.querySelectorAll(".sticker");
const stickerDest = document.getElementById("sticker-selected");

/* Delete sticker */
const delSticker = document.getElementById("mod-del");
const delAll = document.getElementById("btn-del-all");

let stickers = [];

const addSticker = (stick) =>
{
    if (Number(nStickers.textContent) >= maxStickers) return ;

    const newSticker = document.createElement("img");
    newSticker.src = stick.currentTarget.src;

    const name = stick.currentTarget.dataset.sticker;
    const st = new Sticker(name, newSticker);
    stickers.push(st);

    Modifier.set(st);
    newSticker.addEventListener("click", () => Modifier.set(st));
    stickerDest.appendChild(newSticker);

    nStickers.textContent = Number(nStickers.textContent) + 1;
};

const deleteOneSticker = () => 
{
    nStickers.textContent = Number(nStickers.textContent) - 1;
    Modifier.delete(stickers);
};

const deleteStickers = () =>
{
    stickers = [];
    nStickers.textContent = 0;
    stickerDest.innerHTML = "";
    Modifier.clean();
}

stickerList.forEach(st => st.addEventListener("click", addSticker));
delSticker.addEventListener("click", deleteOneSticker);
delAll.addEventListener("click", deleteStickers);