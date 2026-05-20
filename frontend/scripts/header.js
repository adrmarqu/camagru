const btn = document.getElementById("change");
const n1 = document.getElementById("nav-auth");
const n2 = document.getElementById("nav-guest");

const change = () =>
{
    n1.classList.toggle("hidden");
    n2.classList.toggle("hidden");
};

btn.addEventListener("click", () => change());