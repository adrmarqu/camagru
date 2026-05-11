import DOM from '../core/dom.js';

const Camera =
{
    stream: null,
    cam: null,

    init()
    {
        this.cam = DOM.webcam;
        this.start();
    },

    async start()
    {
        if (this.stream || !this.cam)
            return ;

        try
        {
            this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
        }
        catch (err)
        {
            console.log("Camera: ", err);
            throw err;
        }
        this.cam.srcObject = this.stream;
        await this.cam.play();
    },

    stop()
    {
        if (!this.stream)
            return ;

        this.stream.getTracks().forEach(track => track.stop());
        this.stream = null;
    }
};

export default Camera;