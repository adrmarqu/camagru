import DOM from '../core/dom.js';

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
        const response = await fetch('/api/mergeImages.php',
        {
            method: 'POST',
            body: formData
        });

        if (!response.ok) throw new Error(`Server error: ${response.status}`);
        return await response.blob();
    },

    async upload()
    {
        try
        {
            const res = await fetch(this.photo.src);
            const blob = await res.blob();

            const formData = new FormData();
            formData.append('photo', blob, 'photo.png');

            const response = await fetch('/api/uploadImage.php',
            {
                method: 'POST',
                body: formData
            });
            if (!response.ok) throw new Error(`Server error: ${response.status}`);

            return true;
        }
        catch (error)
        {
            console.log("Error:", error.message);
            return false;
        }
    },

    download()
    {
        const a = document.createElement('a');
        a.href = this.photo.src;
        a.download = `camagru-${Date.now()}.png`;

        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    },
};

export default Export;