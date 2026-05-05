const Camera =
{
    stream: null,
    
    async start(videoElement)
    {
        if (!videoElement)
            throw new Error("Parameters not set");

        if (this.stream && videoElement.srcObject === this.stream)
            return;

        try
        {
            this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
        }
        catch (err)
        {
            console.error("Camera permission denied", err);
            throw err;
        }
        videoElement.srcObject = this.stream;
        await videoElement.play();
    },

    stop()
    {
        if (!this.stream)
            return ;

        this.stream.getTracks().forEach(track => track.stop());
        this.stream = null;
    },

    async elementToBlob(sourceElement, canvasElement)
    {
        if (!sourceElement || !canvasElement)
            throw new Error("Parameters not set");

        const ctx = canvasElement.getContext("2d");
        if (!ctx) throw new Error("Error to obtain context 2d");

        let width, height;

        // video
        if (sourceElement instanceof HTMLVideoElement)
        {
            if (sourceElement.videoWidth === 0 || sourceElement.videoHeight === 0)
                throw new Error("Video not ready yet");

            width = sourceElement.videoWidth;
            height = sourceElement.videoHeight;
        } 
        // img
        else if (sourceElement instanceof HTMLImageElement)
        {
            if (!sourceElement.complete)
                throw new Error("Image not loaded yet");

            width = sourceElement.naturalWidth;
            height = sourceElement.naturalHeight;
        }
        else
            throw new Error("Unsupported element type");

        canvasElement.width = width;
        canvasElement.height = height;

        ctx.drawImage(sourceElement, 0, 0, width, height);

        return await new Promise(resolve => {
            canvasElement.toBlob(resolve, "image/jpeg", 0.92);
        });
    }
};

export default Camera;