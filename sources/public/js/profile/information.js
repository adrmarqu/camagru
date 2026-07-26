/* Change user and email */
const info = document.getElementById("information");
const edit = document.getElementById("btn-info");
const errorUser = document.getElementById("error-user");
const errorEmail = document.getElementById("error-email");
const form = document.getElementById("form-info");
const msgContainer = form.querySelector(".form-container");
const msg = form.getElementById("global-info");
/* Form inputs */
const user = form.user;
const email = form.email;
/* Save values */
const userValue = form.user.value;
const emailValue = form.email.value;
/* Form buttons */
const cancel = form.cancel;
const save = form.save;

const handleEdit = () =>
{
    info.classList.toggle("hidden");
    edit.classList.toggle("hidden");
    form.classList.toggle("hidden");
};

const openEdit = () =>
{
    user.value = userValue;
    email.value = emailValue;
    handleEdit();
};

const setMsg = (message, color) =>
{
    msg.textContent = message;
    msgContainer.classList.add(color);
}

const saveInfo = async (e) =>
{
    e.preventDefault();
    
    const formData = new FormData(form);

    try
    {
        const response = await fetch('/api/profile/user.php',
        {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        /* User or email already in use */
        if (data.success === false)
        {
            errorUser.textContent = data.user;
            errorEmail.textContent = data.email;
            return ;
        }
        /* Success */
        setMsg(data.msg, "verde");
    }
    /* HTTP error */ 
    catch (error) { setMsg(error, "rojo"); }
};

edit.addEventListener("click", openEdit);
cancel.addEventListener("click", handleEdit);
save.addEventListener("click", saveInfo);