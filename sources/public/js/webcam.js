/* 1. Referencias al DOM (Sincronizadas con tu .tpl) */
const webcam = document.getElementById("webcam");
const stickerPicker = document.getElementById("stickers-container"); // Asumiendo que el {{::stickers::}} genera este ID
const stickerOverlay = document.getElementById("sticker-overlay");
const canvas = document.getElementById("photo-canvas");
const photoFinal = document.getElementById("photo-final");
const fileInput = document.getElementById("file-input");

/* Botones */
const btnCapture = document.getElementById("btn-capture");
const btnCancel = document.getElementById("btn-cancel");
const btnUpload = document.getElementById("btn-upload");

/* 2. Inicialización de la Cámara */
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        webcam.srcObject = stream;
    })
    .catch(err => {
        console.error("Error al acceder a la webcam: ", err);
        // Aquí podrías mostrar un mensaje en el UI indicando que la cámara no está disponible
    });

/* 3. Lógica de Stickers */
// Función para añadir el sticker a la pantalla (previsualización)
const addSticker = (imgSource) => {
    // Limpiamos el overlay si solo quieres un sticker a la vez (opcional)
    // stickerOverlay.innerHTML = ""; 

    const newSticker = document.createElement("img");
    newSticker.src = imgSource.src;
    newSticker.alt = imgSource.alt;
    newSticker.classList.add("active-sticker");
    
    // Añadimos una equis o simplemente hacemos que al clickar se borre
    newSticker.onclick = () => {
        newSticker.remove();
        checkCaptureAbility();
    };

    stickerOverlay.appendChild(newSticker);
    checkCaptureAbility();
};

// Activar/Desactivar botón de foto (solo si hay stickers)
const checkCaptureAbility = () => {
    const hasStickers = stickerOverlay.querySelectorAll(".active-sticker").length > 0;
    btnCapture.disabled = !hasStickers;
};

/* 4. Captura y Fusión (Frontend Preview) */
const takePhoto = () => {
    const ctx = canvas.getContext("2d");

    // Sincronizar tamaño del canvas con el video real
    canvas.width = webcam.videoWidth;
    canvas.height = webcam.videoHeight;

    // A. Dibujar el fondo (la webcam)
    ctx.drawImage(webcam, 0, 0, canvas.width, canvas.height);

    // B. Dibujar los stickers encima
    const activeStickers = stickerOverlay.querySelectorAll(".active-sticker");
    activeStickers.forEach(sticker => {
        // Aquí los dibujamos en una posición fija (ej: 0,0) o relativa
        // Para 42, esto es solo visual, la magia real la hará tu PHP
        ctx.drawImage(sticker, 10, 10, 150, 150); 
    });

    // C. Mostrar resultado final y ocultar webcam
    const dataURL = canvas.toDataURL("image/png");
    photoFinal.src = dataURL;
    
    photoFinal.classList.remove("hidden");
    webcam.classList.add("hidden");
    stickerOverlay.classList.add("hidden");
};

/* 5. Subida de Archivos */
const handleFileUpload = (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (event) => {
        const img = new Image();
        img.onload = () => {
            const ctx = canvas.getContext("2d");
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);
            
            photoFinal.src = canvas.toDataURL("image/png");
            photoFinal.classList.remove("hidden");
            webcam.classList.add("hidden");
            stickerOverlay.classList.add("hidden");
        };
        img.src = event.target.result;
    };
    reader.readAsDataURL(file);
};

/* 6. Resetear todo */
const resetApp = () => {
    stickerOverlay.innerHTML = "";
    photoFinal.classList.add("hidden");
    photoFinal.src = "";
    webcam.classList.remove("hidden");
    stickerOverlay.classList.remove("hidden");
    canvas.classList.add("hidden");
    btnCapture.disabled = true;
    fileInput.value = ""; // Limpiar el input de archivo
};

/* 7. Event Listeners */

// Delegación de eventos para los stickers que vienen del PHP
document.addEventListener("click", (e) => {
    if (e.target.matches("#stickers-container img")) {
        addSticker(e.target);
    }
});

btnCapture.addEventListener("click", takePhoto);
btnCancel.addEventListener("click", resetApp);

// El botón "Subir" solo abre el selector de archivos
btnUpload.addEventListener("click", () => fileInput.click());
fileInput.addEventListener("change", handleFileUpload);