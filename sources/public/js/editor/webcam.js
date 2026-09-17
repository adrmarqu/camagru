export default class Webcam
{
    static #video = document.getElementById("webcam-video");
    static #stream = null;

    static async start()
    {
        try 
        {
            this.#stream = await navigator.mediaDevices.getUserMedia(
            {
                video: { width: 1280, height: 720 },
                audio: false
            });
            this.#video.srcObject = this.#stream;
            await this.#video.play();
            return true;
        } 
        catch (error) 
        {
            console.warn("No se pudo acceder a la cámara:", error.message);
            return false;
        }
    }

    static stop()
    {
        if (this.#stream) 
        {
            this.#stream.getTracks().forEach(track => track.stop());
            this.#stream = null;
            this.#video.srcObject = null;
        }
    }

    static capture(canvas)
    {
        if (!this.#video) return null;

        const ctx = canvas.getContext("2d");
        
        canvas.width = this.#video.videoWidth;
        canvas.height = this.#video.videoHeight;
        
        ctx.drawImage(this.#video, 0, 0, canvas.width, canvas.height);
        
        return canvas.toDataURL("image/png");
    }
}

document.addEventListener("beforeunload", Webcam.stop);