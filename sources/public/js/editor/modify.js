const title = document.getElementById("mod-title");
const size = document.getElementById("mod-size");
const rotate = document.getElementById("mod-rot");
const del = document.getElementById("mod-del");

export default class Modifier
{
    static #sticker = null;

    static clean()
    {
        if (Modifier.#sticker)
            Modifier.#sticker.select(false);

        Modifier.#sticker = null;

        title.textContent = "";
        size.value = 1;
        rotate.value = 0;
        del.disabled = true;
    }

    static set(sticker)
    {
        if (!sticker) return ;

        if (Modifier.#sticker && Modifier.#sticker !== sticker)
            Modifier.#sticker.select(false);

        Modifier.#sticker = sticker;
        Modifier.#sticker.select(true);

        title.textContent = sticker.getName();
        size.value = sticker.getSize();
        rotate.value = sticker.getRotation();
        del.disabled = false;
    }

    static updateSize()
    {
        if (!Modifier.#sticker) return ;

        const val = parseFloat(size.value);

        if (val < 0.3 || val > 2.5) return ;
        Modifier.#sticker.setSize(val);
    }

    static updateRotation()
    {
        if (!Modifier.#sticker) return ;

        const rot = Number(rotate.value);

        if (rot < -180 || rot > 180) return ;
        Modifier.#sticker.setRotation(rot);
    }

    static updateX()
    {
        if (!Modifier.#sticker) return ;
    }

    static updateY()
    {
        if (!Modifier.#sticker) return ;
    }

    static delete(list)
    {
        if (!Modifier.#sticker) return ;
       
        const index = list.indexOf(Modifier.#sticker);
        if (index !== -1)
            list.splice(index, 1);

        Modifier.#sticker.remove();
        Modifier.clean();
    }

    static isModifierElement(element)
    {
        const container = del?.parentElement;
        return !!(container && container.contains(element));
    }
}

size.addEventListener("input", Modifier.updateSize);
rotate.addEventListener("input", Modifier.updateRotation);