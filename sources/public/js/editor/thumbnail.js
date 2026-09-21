const thumbnailList = document.getElementById("thumbnail-list");
const previewDialog = document.getElementById("preview-dialog");
const dialogImg = document.getElementById("dialog-img");
const dialogClose = document.getElementById("dialog-close");
const dialogDownload = document.getElementById("dialog-download");
const dialogDelete = document.getElementById("dialog-delete");

export default class Thumbnail
{
    static #showMsg = null;
    static #t = (k) => k;
    static #currentSrc = null;
    static #currentLi = null;

    static init(options = {})
    {
        if (options.showMessage)
            Thumbnail.#showMsg = options.showMessage;
        if (options.t)
            Thumbnail.#t = options.t;

        if (thumbnailList)
        {
            thumbnailList.addEventListener("click", (e) =>
            {
                const delBtn = e.target.closest(".thumbnail-del-btn");
                if (delBtn)
                {
                    e.stopPropagation();
                    const li = delBtn.closest("li");
                    const img = li?.querySelector("img.preview");
                    if (img && li)
                        Thumbnail.delete(img.src, li);
                    return;
                }

                const img = e.target.closest("img.preview");
                if (img)
                {
                    const li = img.closest("li");
                    Thumbnail.openDialog(img.src, li);
                }
            });
        }

        if (previewDialog)
        {
            if (dialogClose)
            {
                dialogClose.addEventListener("click", () => Thumbnail.closeDialog());
            }

            // Close when clicking outside the dialog content (on backdrop)
            previewDialog.addEventListener("click", (e) =>
            {
                const rect = previewDialog.getBoundingClientRect();
                const isInDialog = (
                    rect.top <= e.clientY &&
                    e.clientY <= rect.top + rect.height &&
                    rect.left <= e.clientX &&
                    e.clientX <= rect.left + rect.width
                );
                if (!isInDialog)
                {
                    Thumbnail.closeDialog();
                }
            });

            if (dialogDownload)
            {
                dialogDownload.addEventListener("click", () => Thumbnail.downloadCurrent());
            }

            if (dialogDelete)
            {
                dialogDelete.addEventListener("click", () => Thumbnail.deleteCurrent());
            }
        }
    }

    static openDialog(src, li)
    {
        if (!previewDialog || !src) return;

        Thumbnail.#currentSrc = src;
        Thumbnail.#currentLi = li || null;

        if (dialogImg)
            dialogImg.src = src;

        previewDialog.showModal();
    }

    static closeDialog()
    {
        if (!previewDialog) return;
        previewDialog.close();
        Thumbnail.#currentSrc = null;
        Thumbnail.#currentLi = null;
    }

    static downloadCurrent()
    {
        if (!Thumbnail.#currentSrc) return;

        const filename = Thumbnail.#currentSrc.split("/").pop()?.split("?")[0] || "camagru_photo.webp";
        const link = document.createElement("a");
        link.href = Thumbnail.#currentSrc;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    static async deleteCurrent()
    {
        if (!Thumbnail.#currentSrc) return;

        const srcToDelete = Thumbnail.#currentSrc;
        const liToDelete = Thumbnail.#currentLi;

        Thumbnail.closeDialog();
        await Thumbnail.delete(srcToDelete, liToDelete);
    }

    static async delete(src, liElement)
    {
        if (!src) return;

        try
        {
            const response = await fetch("/api/delete_photo.php",
            {
                method: "POST",
                headers:
                {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({ src: src })
            });

            const text = await response.text();
            let data;
            try
            {
                data = JSON.parse(text);
            }
            catch (_)
            {
                throw new Error(Thumbnail.#t("invalidResponse"));
            }

            if (!response.ok || !data.success)
                throw new Error(data.message || Thumbnail.#t("deleteError"));

            if (liElement)
            {
                liElement.classList.add("fade-out");
                setTimeout(() => liElement.remove(), 250);
            }

            if (Thumbnail.#showMsg)
                Thumbnail.#showMsg(data.message || Thumbnail.#t("deleteSuccess"), false);
        }
        catch (err)
        {
            console.error("Error deleting photo:", err.message || err);
            if (Thumbnail.#showMsg)
                Thumbnail.#showMsg(err.message || Thumbnail.#t("deleteError"), true);
        }
    }

    static add(src)
    {
        if (!src || !thumbnailList) return;

        const li = document.createElement("li");
        li.className = "thumbnail-item";

        const img = document.createElement("img");
        img.src = src;
        img.alt = "Thumbnail";
        img.classList.add("preview");

        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "thumbnail-del-btn";
        btn.title = "Eliminar";
        btn.setAttribute("aria-label", "Eliminar");
        btn.innerHTML = "&times;";

        li.appendChild(img);
        li.appendChild(btn);
        thumbnailList.prepend(li);
    }
}