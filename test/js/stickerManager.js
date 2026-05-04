const StickerManager = {
    getMetadata(container, video) {
        const stickers = container.querySelectorAll(".sticker-on-webcam");
        const scaleX = video.videoWidth / video.clientWidth;
        const scaleY = video.videoHeight / video.clientHeight;

        return Array.from(stickers).map(s => ({
            name: s.dataset.stickerName,
            x: parseFloat(s.style.left) * scaleX,
            y: parseFloat(s.style.top) * scaleY,
            width: s.clientWidth * scaleX,
            height: s.clientHeight * scaleY
        }));
    }
};