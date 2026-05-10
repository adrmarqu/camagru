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
        const response = await fetch('mi_archivo.php',
        {
            method: 'POST',
            body: formData
        });

        /*
            response =
            {
                ok: bool,
                status: code
                message: message
                headers {...}
                body: stream (imagen)
            }
        */

        if (!response.ok) throw new Error(`Server error: ${response.message}`);
        return await response.blob();
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