const Camera = {
    stream: null,
    async start(videoElement) {
        this.stream = await navigator.mediaDevices.getUserMedia({ video: true });
        videoElement.srcObject = this.stream;
    },
    stop() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
    },
    takeBlob(videoElement, canvasElement) {
        canvasElement.width = videoElement.videoWidth;
        canvasElement.height = videoElement.videoHeight;
        const ctx = canvasElement.getContext("2d");
        ctx.drawImage(videoElement, 0, 0);
        return new Promise(resolve => canvasElement.toBlob(resolve, 'image/jpeg'));
    }
};