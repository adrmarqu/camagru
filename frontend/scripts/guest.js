const burguer = document.getElementById("burguer");
const burguerDrop = document.getElementById("burguer-drop");

const btnLang = document.getElementById("btn-lang");
const langDrop = document.getElementById("drop-lang");

const toggleBurguer = (e) =>
{
    e.stopPropagation();
    burguer.classList.toggle("active");
    burguerDrop.classList.toggle("hidden");
};

const toggleLang = (e) =>
{
    e.stopPropagation();
    langDrop.classList.toggle("hidden");
};

const closeMenus = (e) =>
{
    if (!e.target.closest("#burguer") && !e.target.closest("#burguer-drop"))
    {
        burguer.classList.remove("active");
        burguerDrop.classList.add("hidden");
    }
    
    if (!e.target.closest("#btn-lang") && !e.target.closest("#drop-lang"))
        langDrop.classList.add("hidden");
};

burguer.addEventListener("click", (e) => toggleBurguer(e));
btnLang.addEventListener("click", (e) => toggleLang(e));
document.addEventListener("click", (e) => closeMenus(e));