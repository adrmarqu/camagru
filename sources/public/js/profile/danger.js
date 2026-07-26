/* Delete account */
const dialog = document.getElementById("dialog-del");
const btnDel = document.getElementById("btn-del");
const errorDel = document.getElementById("error-del");
const form = document.getElementById("form-del");
const msgContainer = form.querySelector(".form-container");
const msg = form.getElementById("global-danger");
/* Form inputs */
const password = form.password;
/* Form buttons */
const cancelBtn = form.cancel;
const saveBtn = form.save;

const setMsg = (message, color) =>
{
    msg.textContent = message;
    msgContainer.classList.add(color);
}
const openDialog = () => dialog.showModal();
const closeDialog = () => dialog.close();

const deleteAccount = async (e) =>
{
    e.preventDefault();

    const formData = new FormData(form);

    try
    {
        const response = await fetch('/api/profile/delete.php',
        {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        /* Wrong password */
        if (data.success === false)
        {
            errorDel.textContent = data.error;
            return ;
        }
        /* Success */
        setMsg(data.msg, "verde");
    }
    /* HTTP error */ 
    catch (error) { setMsg(error, "rojo"); }
};

btnDel.addEventListener("click", openDialog);
cancelBtn.addEventListener("click", closeDialog);
saveBtn.addEventListener("click", deleteAccount);