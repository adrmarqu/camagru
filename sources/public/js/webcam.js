/* List of stickers */
const stickersContainer = document.getElementById("stickers-container");
const stickers = document.querySelectorAll("#stickers-container img");

/* Cam */
const dinContainer = document.getElementById("dinamic-stickers-container");

const webcam = document.getElementById("webcam");
const canvas = document.getElementById("canvas");
const result = document.getElementById("final-img");


/* Buttons */
const btnContainer = document.getElementById("btn-container");

const btnCancel = document.getElementById("btn-cancel");
const btnSend = document.getElementById("btn-send");
const btnUpload = document.getElementById("btn-upload");

let state = 0;

navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => {
    webcam.srcObject = stream;
    webcam.play();
})
.catch(err => console.error("Camera error: ", err));

const reset = () =>
{
    state = 0;
    dinamicContainer.innerHTML = "";

    btnSend.disabled = true;
    
    btnCancel.classList.add("transparent");
    
    btnUpload.classList.remove("hidden");
    btnUpload.classList.add("transparent");

    stickersContainer.classList.remove("transparent");
    webcam.classList.remove("hidden");
    canvas.classList.add("hidden");
    result.classList.add("hidden");
};

reset();

const manageSendBtn = () =>
{
    btnSend.disabled = (dinContainer.getElementsByClassName('img-cam').length === 0)
}

const addSticker = (sticker) =>
{
    const div = document.createElement("div");
    div.classList.add("sticker-cross");

    const img = document.createElement("img");
    img.src = sticker.src;
    img.alt = sticker.alt;
    img.title = sticker.title;

    const cross = document.createElement("btn");
    cross.innerHTML = "X";
    cross.classList.add("cross");
    cross.addEventListener("click", removeSticker(div));

    div.appendChild(img);
    div.appendChild(cross);
    dinContainer.appendChild(div);
    manageSendBtn();
};

const removeSticker = (data) =>
{
    if (!data) return;
    
    data.remove();
    manageSendBtn();
};

/* State 1 - Select and confirm the stickers */
const saveStickers = () =>
{
    stickersContainer.classList.add("transparent");
    btnCancel.classList.remove("transparent");
    btnUpload.classList.remove("transparent");

    state = 1;
};

/* State 2 - Get the image (photo or upload file) */
const makePhoto = () =>
{
    if (webcam.videoWidth === 0) return; 

    const ctx = canvas.getContext("2d");

    canvas.width = webcam.videoWidth;
    canvas.height = webcam.videoHeight;

    ctx.drawImage(webcam, 0, 0, canvas.width, canvas.height);

    previewContainer.classList.add("hidden");
    ResultContainer.classList.remove("hidden");
    image = true;

    const dataURL = canvas.toDataURL("image/png");
    img.src = dataURL;

    // Enviarlo al server y fusionarlo
};

const uploadPhoto = () =>
{
    // Abrir archivo png
    // Enviarlo al server y fusionarlo
};

/* State 3 - Show the result and decide */
const sendImage = () =>
{
    btnUpload.classList.add("hidden");
    
    /* Enviarlo al server para que lo guarde en la bbdd y en uploads */
};

stickers.forEach(img =>
{
    img.addEventListener("click", () => addSticker(img));
});

btnCancel.addEventListener("click", reset);
btnSend.addEventListener("click", () =>
{
    if (state === 0)    saveStickers();
    else                makePhoto();
});
btnUpload.addEventListener("click", sendImage);