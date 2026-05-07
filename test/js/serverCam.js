const mergeImg = async (img, stickers) =>
{
    const formData = new FormData();

    const bg = await fetch(img.src).then(r => r.blob());
    formData.append("background", bg, "background.png");

    [...stickers].forEach((sticker, i) =>
    {
        formData.append(`x_${i}`, sticker.dataset.x ?? 0);
        formData.append(`y_${i}`, sticker.dataset.y ?? 0);

        if (sticker.file)
            formData.append(`sticker_${i}`, sticker.file);
        else
            formData.append(`sticker_${i}_name`, sticker.dataset.stickerName ?? "");
    });

    const response = await fetch("archivo.php",
    {
        method: "POST",
        body: formData
    });

    if (!response.ok) return null;
    return await response.blob();
};

const uploadImg = async (blob) =>
{
    const formData = new FormData();
    formData.append("image", blob, "selfie.png");

    const response = await fetch("archivo.php",
    {
        method: "POST",
        body: formData
    });

    return await response.json();
};

export const Merge =
{
    async download(img, container, alreadyMerged)
    {
        let blob;

        if (!alreadyMerged)
        {
            blob = await mergeImg(img, container.children);
            if (!blob) return "";
        }
        else
            blob = await fetch(img.src).then(r => r.blob());

        const url = URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;

        a.download = `photo-${Date.now()}.png`;
        a.click();

        URL.revokeObjectURL(img.src);
        return url;
    },

    async upload(img, container, alreadyMerged)
    {
        let blob;

        if (!alreadyMerged)
        {
            blob = await mergeImg(img, container.children);
            if (!blob) return null;
            img.src = URL.createObjectURL(blob);
        }
        else
            blob = await fetch(img.src).then(r => r.blob());

        return await uploadImg(blob);
    }
};