import Export from "../export/export.js";
import DOM from "../core/dom.js";

const Capture =
{
    photo: null,
    input: null,
    canvas: null,
    overlay: null,

    init()
    {
        this.photo = DOM.photoFinal;
        this.input = DOM.fileInput;
        this.canvas = DOM.canvas;
        this.overlay = DOM.stickerOverlay;
    },

    async getPhoto(local)
    {
        let blob = local ? await this._fromSelfie() : this._fromInput();
        if (!blob) return ;

        const stickers = this._getStickers();
        if (!stickers) return ;

        const formData = new FormData();
        
        formData.append('photo', blob);
        formData.append("stickers", JSON.stringify(stickers));

        return Export.merge(formData);
    },

    async _fromSelfie()
    {
        return new Promise(resolve =>
        {
            this.canvas.toBlob(blob => resolve(blob), 'image/jpeg', 0.9);
        });
    },

    _fromInput()
    {
        const file = this.input.files[0];
        if (!blob) { console.warn("Image not set"); return null; }

        return file;
    },    

    _getStickers()
    {
        const stickerList = Array.from(this.overlay.children);
        if (!stickerList) return null;

        const stickers = stickerList.map(sticker =>
        ({
            x: Number(sticker.dataset.x || 0),
            y: Number(sticker.dataset.y || 0),
            scale: Number(sticker.dataset.scale || 1),
            rotation: Number(sticker.dataset.rotation || 0),
            src: sticker.dataset.stickerFile
        }));
        return stickers;
    },
};

export default Capture;