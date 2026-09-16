export default class Sticker
{
    #name;
    #image;
    #size = 1;
    #rotation = 1;
    #x = 0;
    #y = 0;

    constructor(name, image)
    { 
        this.#name = name || "Error";
        this.#image = image;
    }

    setSize(size) { this.#size = size; }
    setRotation(rotation) { this.#rotation = rotation; }
    setX(x) { this.#x = x; }
    setY(y) { this.#y = y; }

    getName() { return this.#name; }
    getSize() { return this.#size; }
    getRotation() { return this.#rotation; }
    getX() { return this.#x; }
    getY() { return this.#y; }

    remove() { this.#image.remove(); }
}