const StickerManager =
{
    getMetadata(container, video)
    {
        const stickers = container.querySelectorAll(".sticker-on-webcam");
        
        const scaleX = video.videoWidth / video.clientWidth;
        const scaleY = video.videoHeight / video.clientHeight;

        return Array.from(stickers).map(s =>
        ({
            name: s.dataset.stickerName,
            x: parseFloat(s.style.left) * scaleX,
            y: parseFloat(s.style.top) * scaleY,
            width: s.clientWidth * scaleX,
            height: s.clientHeight * scaleY
        }));
    },

    createSticker(img)
    {
        const clone = document.createElement("img");
        /* Data img */
        clone.src = img.src;
        clone.alt = img.alt;
        clone.title = img.title;

        /* Name for the server */
        clone.dataset.stickerName = img.src.split('/').pop();
        
        /* Initial position */
        clone.style.left = "50px";
        clone.style.top = "50px";

        clone.classList.add("sticker-on-webcam");

        return clone;
    },
};

export default StickerManager;