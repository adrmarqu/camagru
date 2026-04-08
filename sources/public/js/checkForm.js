const form = document.getElementById("form-cam");

const checkUser = (user) =>
{
    // empieza por letra
    // minimo 3 letras
    // maximo 20 letras
    // que no tenga simbolos, solo letras, numeros
};

const checkEmail = (email) =>
{

};

const checkPass = (pass, rep) =>
{
    const checkRepeat = (pass, rep) =>
    {
        if (pass !== rep)
            err = "Password are not equal";
    };

    // Check pass

    if (err === "")
        checkRepeat(pass, rep);
};

const checkTerm = (term) =>
{
    if (!term)
        err = "Necesitas aceptar los terminos";
};

const checkForm = (e) =>
{
    const checkSignin = () =>
    {
        checkUser();
        checkEmail();
        checkPass();
        checkTerm();
    };

    const checkupdateUser = () =>
    {
        checkUser();
    };

    const checkupdatePass = () =>
    {
        checkPass();
    };

    const checkupdateEmail = () =>
    {
        checkEmail();
    };

    switch (form.type.value)
    {
        case 'login':
            break ;
        case 'signin':
            checkSignin();
            break ;
        case 'updateUser':
            checkupdateUser();
            break ;
        case 'updatePass':
            checkupdatePass();
            break ;
        case 'updateEmail':
            checkupdateEmail();
            break ;
        default:
            err = "Unknown error";
    }
    if (err !== "")
    {
        e.prevetDefault();
        window.alert(err);
    }
};

document.addEventListener('submit', checkForm);