import DOM from "./dom.js";
import States from "./states.js";
import Export from "../export/export.js";
import Capture from "../camera/capture.js";
import Sticker from "../stickers/stickers.js";
import Modify from "../stickers/modify.js";

const Events =
{
    moving: false,
    offsetX: 0,
    offsetY: 0,
    sticker: null,

    ui:
    {
        btnPrev: null,
        btnNext: null,
        btnPort: null,

        input: null,
        
        stickerList: null,

        btnSize: null,
        btnRotate: null,
        btnDel: null,
    },

    prepare()
    {
        this.ui.btnPrev = DOM.btnCancel;
        this.ui.btnNext = DOM.btnCapture;
        this.ui.btnPort = DOM.btnUpload;
        this.ui.input = DOM.fileInput;
        this.ui.stickerList = DOM.stickerList;
        this.ui.btnSize = DOM.sizeMod;
        this.ui.btnRotate = DOM.rotMod;
        this.ui.btnDel = DOM.delMod;

        this.init();
    },

    init()
    {
        /* Buttons */
        this.ui.btnPrev.addEventListener("click", () => States.restState());
        this.ui.btnNext.addEventListener("click", () => States.sumState());
        this.ui.btnPort.addEventListener("click", () =>
        {
            if (States.getState() === 3)
                this.ui.input.click();
            else
                Export.download();
        });
        this.ui.input.addEventListener("change", async () => 
        {
            if (await Capture.getPhoto(false))
                States.sumState();
        });

        /* Stickers */
        this.ui.stickerList.forEach(sticker =>
        {
            sticker.addEventListener("click", () => Sticker.create(sticker));
        });

        /* Modificator */

        this.ui.btnSize.addEventListener("input", () => Modify.modify());
        this.ui.btnRotate.addEventListener("input", () => Modify.modify());
        this.ui.btnDel.addEventListener("click", () => 
        {
            Modify.delete();
            Sticker.remove();
        });

        /* Sticker move */

        document.addEventListener("mousemove", (e) =>
        {
            if (!this.moving || !this.sticker) return;

            this.sticker.style.left = `${e.clientX - this.offsetX}px`;
            this.sticker.style.top = `${e.clientY - this.offsetY}px`;
        });

        document.addEventListener("mouseup", () =>
        {            
            this.moving = false;

            if (!this.sticker) return ;
            this.sticker.classList.remove("dragging");
            this.sticker = false;
        });
    },

    stickerMod(sticker)
    {
        sticker.addEventListener("click", () => Modify.show(sticker));
        Modify.show(sticker);
        this._stickerMove(sticker);
    },

    _stickerMove(sticker)
    {
        sticker.addEventListener("mousedown", e =>
        {
            this.moving = true;

            this.offsetX = e.clientX - sticker.offsetLeft;
            this.offsetY = e.clientY - sticker.offsetTop;

            sticker.classList.add("dragging");
            this.sticker = sticker;
        });
    }

};

export default Events;