import DOM from "../core/dom.js";
import Events from "../core/events.js";
import States from "../core/states.js";

const Sticker = 
{
    overlay: null,
    limit: 5,

    init()
    {
        this.overlay = DOM.stickerOverlay;
    },

    create(sticker)
    {
        if (this.overlay.children.length >= this.limit || !sticker)
            return ;
     
        this.add();

        const clone = document.createElement("img");
        clone.src = sticker.src;
        clone.alt = sticker.alt;
        clone.title = sticker.title;

        const file = sticker.src.split('/').pop();
        const name = file.substring(0, file.lastIndexOf('.'));
        const upper = name.charAt(0).toUpperCase() + name.slice(1);

        clone.dataset.stickerFile = file;
        clone.dataset.stickerName = upper;
        clone.dataset.x = 0;
        clone.dataset.y = 0;
        clone.dataset.scale = 1;
        clone.dataset.rotation = 0;
        /* Init pos in css */

        Events.stickerMod(clone);

        clone.classList.add("sticker-on-webcam");
        this.overlay.appendChild(clone);
    },

    add()
    {
        if (this.overlay.children.length === 0)
            States.sticker();
    },

    remove()
    {
        if (this.overlay.children.length === 0)
            States.initial();
    }
};

export default Sticker;