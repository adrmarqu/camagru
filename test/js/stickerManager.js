const overlay = document.getElementById("sticker-overlay");

const LIMIT_STICKERS = 5;

export const StickerManager =
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

    create(img)
    {
        if (overlay.children.length >= LIMIT_STICKERS || !img)
            return null;

        const clone = document.createElement("img");
        clone.src = img.src;
        clone.alt = img.alt;
        clone.title = img.title;

        /* file.png */
        clone.dataset.stickerFile = img.src.split('/').pop();

        /* File */
        const str = clone.dataset.stickerFile;
        const name = str.substring(0, str.lastIndexOf('.'));
        const n = name.charAt(0).toUpperCase() + name.slice(1);
        clone.dataset.stickerName = n;

        clone.dataset.x = 0;
        clone.dataset.y = 0;
        clone.dataset.scale = 1;
        clone.dataset.rotate = 0;

        /* clone.style.left = "50px";
        clone.style.top = "50px"; */

        clone.classList.add("sticker-on-webcam");
        overlay.appendChild(clone);

        return clone;
    },

    modify(img)
    {
        const x = img.dataset.x || 0;
        const y = img.dataset.y || 0;
        const scale = img.dataset.scale || 1;
        const rotate = img.dataset.rotate || 0;

        img.style.transform = `
            translate(${x}px, ${y}px)
            scale(${scale})
            rotate(${rotate}deg)
        `;
    }
};