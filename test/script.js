const webcam = document.getElementById("webcam");
const stickerList = document.querySelectorAll("#sticker-picker img");
const stickerOverlay = document.getElementById("sticker-overlay");
const canvas = document.getElementById("photo-canvas");
const photoFinal = document.getElementById("photo-final");
const fileInput = document.getElementById("file-input");

const btnCapture = document.getElementById("btn-capture");
const btnCancel = document.getElementById("btn-cancel");
const btnUpload = document.getElementById("btn-upload");

navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => {
    webcam.srcObject = stream;
})
.catch(err => {
    console.error("Error al acceder a la webcam: ", err);
});

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
    clone.classList.add("sticker-on-webcam");

    stickerOverlay.appendChild(clone);

    btnCapture.disabled = false;

    clone.onclick = () =>
    {
        clone.remove();
        if (stickerOverlay.children.length === 0)
            btnCapture.disabled = true;
    };
};

stickerList.forEach(img =>
{
    img.addEventListener("click", () => cloneSticker(img));
});