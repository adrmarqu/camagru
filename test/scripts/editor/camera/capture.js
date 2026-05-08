import Export from "../export/export.js";
import DOM from "../core/dom.js";

const Capture =
{
    photo: null,
    input: null,
    canvas: null,

    init()
    {
        this.photo = DOM.photoFinal;
        this.input = DOM.fileInput;
        this.canvas = DOM.canvas;
    },

    async _fromInput()
    {
        const file = this.input.files[0];
        if (!file) { console.warn("Image not set"); return null; }

        const formData = new FormData();
        formData.append('photo', file);
        return formData;
    },

    async _fromSelfie()
    {
        return new Promise(resolve =>
        {
            this.canvas.toBlob(blob =>
            {
                const formData = new FormData();
                formData.append('photo', blob, 'selfie.jpg');
                resolve(formData);
            }, 'image/jpeg', 0.9);
        });
    },

    async getPhoto(local)
    {
        if (local)
            data = await Capture._fromSelfie();
        else
            data = await Capture._fromInput();
        Export.merge(data);
    },
};

export default Capture;