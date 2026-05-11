import DOM from './dom.js';
import Capture from '../camera/capture.js';
import Export from '../export/export.js';

const States = 
{
    ui: {},
    _current: 0,

    /* PUBLIC */

    init()
    {
        this.ui =
        {
            /* Visual */
            img: DOM.photoFinal,
            cam: DOM.webcam,
            
            /* Containers */
            stick: DOM.stickerContainer,    // Stickers aside
            over: DOM.stickerOverlay,       // Stickers video
            mod: DOM.stickerMod,            // Sticker modify
            preview: DOM.previewContainer,  // Previews

            /* Buttons */
            prev: DOM.btnCancel, 
            next: DOM.btnCapture, 
            port: DOM.btnUpload 
        };

        this.initial();
    },

    sumState()
    {
        if (this._current === 3 && !Capture.getPhoto(true)) return ;
        if (this._current === 4 && !Export.upload()) return ;

        this._current++;

        if (this._current > 4) this.initial();
        this._setState(this._current);
    },

    restState()
    {
        if (this._current === 1) return ;
        this._current--;
        this._setState(this._current);
    },

    getState()
    {
        return this._current;
    },

    initial()
    {
        this._current = 1;

        /* VISUAL */

        this._clean(this.ui.img); this._hide(this.ui.img);
        this._show(this.ui.cam);

        /* CONTAINER */

        this.ui.over.innerHTML = "";
        this._hide(this.ui.mod);
        this._show(this.ui.preview);
        this._show(this.ui.stick);

        /* ACTION */
        
        this._trans(this.ui.prev);
        this._trans(this.ui.port);
        this.ui.next.disabled = true;
    },

    sticker()
    {
        this._current = 2;

        /* CONTAINER */

        this._hide(this.ui.mod);
        this._show(this.ui.preview);
        this._show(this.ui.stick);

        /* ACTION */
        
        this._show(this.ui.prev);
        this._trans(this.ui.port);
        this.ui.next.disabled = false;
    },

    photo()
    {
        this._current = 3;

        /* VISUAL */

        this._clean(this.ui.img); 
        this._hide(this.ui.img);
        this._show(this.ui.cam);

        /* CONTAINER */

        this._hide(this.ui.mod);
        this._trans(this.ui.preview);
        this._trans(this.ui.stick);

        /* ACTION */
        
        this._show(this.ui.prev);
        this._show(this.ui.port);
    },

    result()
    {
        this._current = 4;

        /* VISUAL */

        this._show(this.ui.img);
        this._hide(this.ui.cam);

        /* CONTAINER */

        this._hide(this.ui.mod);
        this._hide(this.ui.preview);
        this._hide(this.ui.stick);

        /* ACTION */
        
        this._show(this.ui.prev);
        this._show(this.ui.port);
    },

    /* PRIVATE */

    _hide(obj)
    {
        obj.className = "hidden";
    },

    _show(obj)
    {
        obj.className = "";
    },

    _trans(obj)
    {
        obj.className = "transparent";
    },

    _clean(obj)
    {
        if (obj.src.startsWith('blob:'))
            URL.revokeObjectURL(obj.src);
        obj.src = "";
    },

    _setState(state)
    {
        switch (state)
        {
            case 1:
                this.initial();
                break ;
            case 2:
                this.sticker();
                break ;
            case 3:
                this.photo();
                break ;
            case 4:
                this.result();
                break ;
            default:
                console.log("Unknown error: State.setState(" + state + ")");
                this.initial();
        }
    }
};

export default States;