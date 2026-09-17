export default class Sticker
{
    #name;
    #image;
    #size = 1;
    #rotation = 0;
    #x = 0;
    #y = 0;

    constructor(name, image)
    { 
        this.#name = name || "Error";
        this.#image = image;
        this.#image.classList.add("selected-sticker");
        this.#initDrag();
        this.update();
    }

    #initDrag()
    {
        let isDragging = false;
        let startX = 0;
        let startY = 0;
        let initialX = 0;
        let initialY = 0;

        this.#image.addEventListener("pointerdown", (e) => {
            if (e.button !== 0) return ;
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            initialX = this.#x;
            initialY = this.#y;
            this.#image.setPointerCapture(e.pointerId);
            e.preventDefault();
        });

        this.#image.addEventListener("pointermove", (e) => {
            if (!isDragging) return ;
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;

            let nextX = initialX + dx;
            let nextY = initialY + dy;

            const container = this.#image.parentElement;
            if (container && container.clientWidth > 0 && container.clientHeight > 0)
            {
                const halfW = container.clientWidth / 2;
                const halfH = container.clientHeight / 2;

                nextX = Math.max(-halfW, Math.min(halfW, nextX));
                nextY = Math.max(-halfH, Math.min(halfH, nextY));
            }

            this.#x = nextX;
            this.#y = nextY;
            this.update();
        });

        const stopDrag = (e) => {
            if (!isDragging) return ;
            isDragging = false;
            try {
                this.#image.releasePointerCapture(e.pointerId);
            } catch (_) {}
        };

        this.#image.addEventListener("pointerup", stopDrag);
        this.#image.addEventListener("pointercancel", stopDrag);
    }

    update()
    {
        this.#image.style.transform = `translate(-50%, -50%) translate(${this.#x}px, ${this.#y}px) scale(${this.#size}) rotate(${this.#rotation}deg)`;
    }

    setSize(size)
    {
        this.#size = size;
        this.update();
    }

    setRotation(rotation)
    {
        this.#rotation = rotation;
        this.update();
    }

    setX(x)
    {
        this.#x = x;
        this.update();
    }

    setY(y)
    {
        this.#y = y;
        this.update();
    }

    getName() { return this.#name; }
    getSize() { return this.#size; }
    getRotation() { return this.#rotation; }
    getX() { return this.#x; }
    getY() { return this.#y; }

    remove() { this.#image.remove(); }

    select(active = true)
    {
        if (active)
            this.#image.classList.add("is-selected");
        else
            this.#image.classList.remove("is-selected");
    }

    toJson()
    {
        return {
            name: this.#image.src,
            x: this.#x,
            y: this.#y,
            size: this.#size,
            rotation: this.#rotation,
        };
    }
}