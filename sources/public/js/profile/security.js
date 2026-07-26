const info = document.getElementById("security");
const edit = document.getElementById("btn-pass");
const errorPass = document.getElementById("error-pass");
const errorNew = document.getElementById("error-new");
const errorConf = document.getElementById("error-confirm");
const form = document.getElementById("form-pass");
const msgContainer = form.querySelector(".form-container");
const msg = form.getElementById("global-sec");
/* Form inputs */
const pass = form.password;
const newPass = form.new_pass;
const conf = form.confirm;
/* Form buttons */
const cancel = form.cancel;
const save = form.save;

const handleEdit = () =>
{
    info.classList.toggle("hidden");
    edit.classList.toggle("hidden");
    form.classList.toggle("hidden");
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
        const response = await fetch('/api/profile/password.php',
        {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        /* Wrong password */
        if (data.success === false)
        {
            errorPass.textContent = data.pass;
            errorNew.textContent = data.new;
            errorConf.textContent = data.conf;
            return ;
        }
        /* Success */
        setMsg(data.msg, "verde");
    }
    /* HTTP error */ 
    catch (error) { setMsg(error, "rojo"); }
};

edit.addEventListener("click", handleEdit);
cancel.addEventListener("click", handleEdit);
save.addEventListener("click", saveInfo);