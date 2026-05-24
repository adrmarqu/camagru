const noti = document.getElementById("noti");
const auth = document.getElementById("remember");

let notiText = [];
let authText = [];

const init = () =>
{
    let lang = window.location.pathname.split('/')[1];

    if (lang === 'es' || lang === 'ca')
    {
        notiText = ['Activar', 'Desactivar'];
        authText = ['Recordar', 'No recordar'];
    }
    else
    {
        notiText = ['Activate', 'Disactivate'];
        authText = ['Remember', 'Not remember'];
    }
    noti.innerHTML = notiText[noti.value];
    auth.innerHTML = authText[auth.value];
};

const toggleNoti = () =>
{
    noti.value = Number(!Number(noti.value));
    noti.innerHTML = notiText[noti.value];
};

const toggleAuth = () =>
{
    auth.value = Number(!Number(auth.value));
    auth.innerHTML = authText[auth.value];
};

noti.addEventListener("click", () => toggleNoti());
auth.addEventListener("click", () => toggleAuth());

init();