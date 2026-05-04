const webcam = document.getElementById("webcam");
const stickerList = document.querySelectorAll("#sticker-picker img");
const stickerOverlay = document.getElementById("sticker-overlay");
const canvas = document.getElementById("photo-canvas");
const photoFinal = document.getElementById("photo-final");
const fileInput = document.getElementById("file-input");

const btnCapture = document.getElementById("btn-capture");
const btnCancel = document.getElementById("btn-cancel");
const btnUpload = document.getElementById("btn-upload");

const startCamera = () =>
{
    navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        webcam.srcObject = stream;
    })
    .catch(err => {
        console.error("Error al acceder a la webcam: ", err);
    });
};

const stopCamera = () =>
{
    const stream = webacam.srcObject;

    if (stream)
    {
        const tracks = stream.getTraacks();
        tracks.forEach(track => track.stop());
        webcam.srcObject = null; 
    }
};

const cloneSticker = (img) =>
{
    if (stickerOverlay.childElementCount >= 5)
    {
        console.log("You reached the limit");
        return ;
    }

    const clone = document.createElement("img");
    clone.src = img.src;
    clone.alt = img.alt;
    clone.title = img.title;
    clone.dataset.stickerName = img.src.split('/').pop();
    console.log("POP:", img.src.split('/').pop());
    clone.classList.add("sticker-on-webcam");

    clone.style.left = "50px";
    clone.style.top = "50px";

    stickerOverlay.appendChild(clone);
    btnCapture.disabled = false;

    clone.onclick = () =>
    {
        clone.remove();
        if (stickerOverlay.children.length === 0)
            btnCapture.disabled = true;
    };
};

const sentToServer = (img) =>
{
    const formData = new FormData();

    /* Add photo */
    formData.append('base', img, 'capture.jpg');

    /* Stickers */

    const stickersData = [];
    const stickersInDOM = document.querySelectorAll(".sticker-on-webcam");

    const scaleX = webcam.videoWidth / webcam.clientWidth;
    const scaleY = webcam.videoHeight / webcam.clientHeight;

    stickersInDOM.forEach(s =>
    {
        stickersData.push(
        {
            name: s.dataset.stickerName,
            x: parseFloat(s.style.left) * scaleX,
            y: parseFloat(s.style.top) * scaleY,
            width: s.clientWidth * scaleX,
            height: s.clientHeight * scaleY
        });
    });

    /* Add stickers */
    formData.append('stickers', JSON.stringify(stickersData));

    /* Send */

    fetch("mi_php",
    {
        method: 'POST',
        body: formData
    })
    .then(res => res.blob())
    .then(final =>
    {
        photoFinal.src = URL.createObjectURL(final);
        photoFinal.classList.remove("hidden");
        webcam.classList.add("hidden");
    })
    .catch(e =>
    {
        console.log("Error:", e);
    });
};

const setImage = () =>
{
    canvas.width = webcam.videoWidth;
    canvas.height = webcam.videoHeight;

    const ctx = canvas.getContext("2d");
    ctx.drawImage(webcam, 0, 0);

    canvas.toBlob(blob =>
    {
        sentToServer(blob);
    }, 'image/jpeg');
};

stickerList.forEach(img =>
{
    img.addEventListener("click", () => cloneSticker(img));
});

btnCapture.addEventListener("click", setImage);

startCamera();