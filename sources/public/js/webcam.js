const video = document.getElementById("webcam");
const btn = document.getElementById("capture");
const canvas = document.getElementById("canvas");
const final = document.getElementById("final");

navigator.mediaDevices.getUserMedia({ video: true })
.then(stream =>
{
    video.srcObject = stream;
});

const makePhoto = () =>
{
    const ctx = canvas.getContext("2d");

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    const dataURL = canvas.toDataURL("image/png");

    final.src = dataURL;
};

btn.addEventListener("click", makePhoto);