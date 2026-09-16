const title = document.getElementById("mod-title");
const size = document.getElementById("mod-size");
const rotate = document.getElementById("mod-rot");
const del = document.getElementById("mod-del");

export default class Modifier
{
    static #sticker = null;

    static clean()
    {
        Modifier.#sticker = null;

        title.textContent = "";
        size.value = 1;
        rotate.value = 0;
        del.disabled = true;
    }

    static set(sticker)
    {
        Modifier.#sticker = sticker;

        title.textContent = sticker.getName();
        size.value = sticker.getSize();
        rotate.value = sticker.getRotation();
        del.disabled = false;
    }

    static uploadSize()
    {
        if (!Modifier.#sticker) return ;
        if (size.value < 0.5 || size.value > 5) return ;
        Modifier.#sticker.setSize(size.value);
    }

    static uploadRotation()
    {
        if (!Modifier.#sticker) return ;
        if (size.value < -180 || size.value > 180) return ;
        Modifier.#sticker.setRotation(rotate.value);
    }

    static uploadX()
    {
        if (!Modifier.#sticker) return ;
    }

    static uploadY()
    {
        if (!Modifier.#sticker) return ;
    }

    static delete(list)
    {
        if (!Modifier.#sticker) return ;

        const index = list.indexOf(Modifier.#sticker);
        if (index !== -1)
            list.splice(Modifier.#sticker);

        Modifier.#sticker.remove();
        Modifier.clean();
    }
}

size.addEventListener("change", Modifier.uploadSize);
rotate.addEventListener("change", Modifier.uploadRotation);