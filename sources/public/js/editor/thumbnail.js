const thumbnailList = document.getElementById("thumbnail-list");

export default class Thumbnail
{
    static add(src)
    {
        if (!src || !thumbnailList) return ;
        
        const li = document.createElement("li");
        const img = document.createElement("img");

        img.src = src;
        img.alt = "Thumbnail";
        img.classList.add("preview");
        
        li.appendChild(img);
        thumbnailList.prepend(li);
    }
}