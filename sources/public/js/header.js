const btn = document.getElementById("btn-drop");
const dropdown = document.getElementById("drop");

const btnLang = document.getElementById("btn-lang");
const langDrop = document.getElementById("drop-lang");

const toggleDrop = (e) =>
{
    e.stopPropagation();
    btn.classList.toggle("active"); // Only works offline (no auth)
    dropdown.classList.toggle("hidden");
};

const toggleLang = (e) =>
{
    e.stopPropagation();
    langDrop.classList.toggle("hidden");
};

const closeMenus = (e) =>
{

    if (!e.target.closest("#btn-drop") && !e.target.closest("#drop"))
    {
        btn.classList.remove("active");
        dropdown.classList.add("hidden");
    }
    
    if (!e.target.closest("#btn-lang") && !e.target.closest("#drop-lang"))
        langDrop.classList.add("hidden");
};

btn.addEventListener("click", (e) => toggleDrop(e));
btnLang.addEventListener("click", (e) => toggleLang(e));
document.addEventListener("click", (e) => closeMenus(e));