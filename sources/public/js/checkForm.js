const form = document.getElementById("form-cam");
const output = document.getElementById("form-msg");

const checkUser = (user) =>
{
    user = user.trim();

    const userPattern = /^[a-zA-Z][a-zA-Z0-9_]{3,20}$/;

    if (!userPattern.test(user))
        return "El usuario tiene que estar entre 3 y 20 caracteres, solo puede tener letras, numeros o guiones bajos y ha de empezar por una letra";
    
    return null;
};

const checkEmail = (email) =>
{
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailPattern.test(email))
        return "Formato de correo incorrecto";
    return null;
};

const checkPass = (pass, rep) =>
{
    const passPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

    if (!passPattern.test(pass))
        return "La contraseña tiene que tener 8 caracteres, 1 mayuscula, 1 minuscula, 1 numero";

    if (!err && pass !== rep)
        return "Passwords are not equal";
    return null;
};

const checkTerm = (term) =>
{
    if (!term)
        return "Necesitas aceptar los terminos";
    return null;
};

const checkForm = (e) =>
{
    const checkSignin = () =>
    {
        err = checkUser(form.user.value);
        if (err) return err;

        err = checkEmail(form.email.value);
        if (err) return err;
        
        err = checkPass(form.pass.value, form.passRep.value);
        if (err) return err;
        
        return checkTerm(form.terms.checked);
    };

    const checkupdateUser = () =>
    {
        return checkUser(form.user.value);
    };

    const checkupdatePass = () =>
    {
        return checkPass(form.pass.value, form.passRep.value);
    };

    const checkupdateEmail = () =>
    {
        return checkEmail(form.email.value);
    };

    err = null;
    switch (form.type.value)
    {
        case 'login':
            break ;
        case 'signin':
            err = checkSignin();
            break ;
        case 'updateUser':
            err = checkupdateUser();
            break ;
        case 'updatePass':
            err = checkupdatePass();
            break ;
        case 'updateEmail':
            err = checkupdateEmail();
            break ;
        default:
            err = "Unknown error";
    }
    if (err)
    {
        e.preventDefault();
        output.innerHTML = err;
        return ;
    }
};

document.addEventListener('submit', checkForm);