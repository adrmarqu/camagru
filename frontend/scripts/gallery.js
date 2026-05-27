const galleryElements = document.querySelectorAll(".gallery-element");

/* Set events into images */
galleryElements.forEach(e =>
{
    const comment = (event) =>
    {
        const btn = event.target.closest(".btn-com");
        if (!btn) return false;

        const container = btn.closest(".gallery-element");
        if (!container) return false;

        const commentContainer = container.querySelector(".comments-container");
        commentContainer.classList.toggle("show");

        const icon = btn.querySelector(".element-icon");
        if (!icon) return false;

        icon.classList.toggle("selected");

        return true;
    };

    const like = (event) =>
    {
        const btn = event.target.closest(".btn-like");
        if (!btn) return false;

        const span = btn.querySelector(".element-icon-span");
        if (!span) return false;

        const icon = btn.querySelector(".element-icon");
        if (!icon) return false;

        //const username = btn.closest(".element-user");

        /* Fetch para enviar un like y devolver la cantidad */
        
        //span.innerHtml = response.likes;

        icon.classList.toggle("selected");

        return true;
    };

    const closeX = (event) =>
    {
        const btn = event.target.closest(".btn-x");
        if (!btn) return false;

        const container = btn.closest(".gallery-element");
        if (!container) return false;

        const commentContainer = container.querySelector(".comments-container");
        commentContainer.classList.remove("show");



        return true;
    };

    e.addEventListener("click", (event) =>
    {
        if (comment(event)) return ;
        if (like(event)) return ;
        if (closeX(event)) return ;
    })
});

/* 

- Gallery element

    - Mirar que se ha pulsado

    - Conseguir los elementos necesarios

    - Actuar
    
*/