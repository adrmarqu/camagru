import DOM from "../core/dom.js";

/* Connect with api */
const Export =
{
    photo: null,

    init()
    {
        this.photo = DOM.photoFinal;
    },

    async merge(formData)
    {
        return false;
    },

    async download()
    {
        /* Download photo */
    },

    async upload()
    {
        /* Upload photo */
    }
};

export default Export;