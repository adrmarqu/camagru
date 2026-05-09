import DOM from "../core/dom.js";
import States from "../core/states.js";

const Modify = 
{
    ui:
    {
        container: null,
        preview: null,

        title: null,
        size: null,
        rotate: null,
    },
    sticker: null,

    init()
    {
        this.ui.container = DOM.stickerMod;
        this.ui.preview = DOM.previewContainer;
        this.ui.title = DOM.modTitle;
        this.ui.size = DOM.sizeMod;
        this.ui.rotate = DOM.rotMod;
    },

    show(sticker)
    {
        this.ui.container.className = "";
        this.ui.preview.className = "hidden";

        this.ui.title.innerHTML = sticker.dataset.stickerName;
        this.ui.size.value = sticker.dataset.scale;
        this.ui.rotate.value = sticker.dataset.rotate;

        this.sticker = sticker;
    },

    hide()
    {
        this.ui.container.className = "hidden";
        this.ui.preview.className = "";

        this.sticker = null;
    },

    modify()
    {
        const x = this.sticker.dataset.x || 0;
        const y = this.sticker.dataset.y || 0;
        const scale = this.ui.size.value || 1;
        const rotation = this.ui.rotate.value || 0;

        this.sticker.dataset.scale = scale;
        this.sticker.dataset.rotation = rotation;

        this.sticker.style.transform = `
            translate(${x}px, ${y}px)
            scale(${scale})
            rotate(${rotation}deg)
        `;
    },

    delete()
    {
        this.sticker.remove();
        this.sticker = null;
        this.hide();
    },
};

export default Modify;