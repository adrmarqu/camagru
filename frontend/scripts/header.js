const btn = document.getElementById("change");
const n1 = document.getElementById("nav-auth");
const n2 = document.getElementById("nav-guest");
const logout = document.getElementById("logout");
const burguer = document.getElementById("burguer-guest");
const dropGuest = document.getElementById("drop-guest");
const dropAuth = document.getElementById("drop-auth");
const btnDrop = document.getElementById("btn-drop");

const change = () =>
{
    n1.classList.toggle("hidden");
    n2.classList.toggle("hidden");
};

const change2 = () =>
{
    n1.classList.add("hidden");
    n2.classList.remove("hidden");
};

const burguerActivate = () =>
{
    burguer.classList.toggle("active");
    dropGuest.classList.toggle("hidden");
};

const dropActivate = () =>
{
    dropAuth.classList.toggle("hidden");
}; 

const hide = (e) =>
{
    if (e.target == btnDrop || e.target == burguer) return ;

    dropAuth.classList.add("hidden");
    burguer.classList.remove("active");
    dropGuest.classList.add("hidden");
}

btn.addEventListener("click", () => change());
logout.addEventListener("click", () => change2());
burguer.addEventListener("click", () => burguerActivate());
btnDrop.addEventListener("click", () => dropActivate());
document.addEventListener("click", (e) => hide(e));