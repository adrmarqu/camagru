import DOM from "./dom.js";
import States from "./states.js";
import Actions from "./actions.js";
import Export from "../export/export.js";
import Capture from "../camera/capture.js";

const Events =
{
    ui:
    {
        btnPrev: null,
        btnNext: null,
        btnPort: null,
    },

    prepare()
    {
        this.ui.btnPrev = DOM.btnCancel;
        this.ui.btnNext = DOM.btnCapture;
        this.ui.btnPort = DOM.btnUpload;

        this.init();
    },

    init()
    {
        this.ui.btnPrev.addEventListener("click", States.restState);
        this.ui.btnNext.addEventListener("click", States.sumState);
        this.ui.btnPort.addEventListener("click", () =>
        {
            if (States.getState() === 3)
            {
                Capture.getPhoto(false);
                States.sumState();
            }
            else
                Export.download();
        });
    }
}

export default Events;