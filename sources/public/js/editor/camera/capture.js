import Export from "../export/export.js";
import DOM from "../core/dom.js";
import States from "../core/states.js";

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
        try
        {
            let blob = local ? await this._fromSelfie() : this._fromInput();
            if (!blob) throw new Error("Failed to get the image");

            const stickers = this._getStickers();
            if (!stickers) throw new Error("No stickers selected");

            const formData = new FormData();            
            formData.append('photo', blob);
            formData.append("stickers", JSON.stringify(stickers));

            const blobFinal = await Export.merge(formData);

            States._clean(this.photo);
            this.photo.src = URL.createObjectURL(blobFinal);
            return true;
        }
        catch (error)
        {
            console.error("Error:", error.message);
            States.initial();
            return false;
        }
    },

    async _fromSelfie()
    {
        return new Promise(resolve =>
        {
            this.canvas.toBlob(blob => resolve(blob), 'image/png');
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
            rotate: Number(sticker.dataset.rotate || 0),
            src: sticker.dataset.stickerFile
        }));
        return stickers;
    },
};

export default Capture;