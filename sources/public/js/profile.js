/* Info containers */
const info = document.getElementById("info-view");
const editionInfo = document.getElementById("form-info");
/* Info buttons */
const btnInfo = document.getElementById("btn-edit-info");
const cancelInfo = document.getElementById("btn-cancel-info");
/* Info form */
const username = document.getElementById("user-val");
const email = document.getElementById("email-val");
const formInfo = document.getElementById("form-info");
/* Security containers */
const sec = document.getElementById("security-view");
const editionSec = document.getElementById("form-security");
/* Security buttons */
const btnSec = document.getElementById("btn-edit-security");
const cancelSec = document.getElementById("btn-cancel-security");
/* Preferences */
const formPref = document.getElementById("form-preferences");
const notiCheckbox = document.getElementById("notifications");
/* Danger */
const btnDel = document.getElementById("btn-del");
const dialog = document.getElementById("dialog-del");
const formDel = document.getElementById("form-del");
const cancelDel = document.getElementById("btn-cancel-del");
const submitDel = document.getElementById("btn-submit-del");
const spinnerDel = document.getElementById("spinner-del");
const delPassword = document.getElementById("del-password");
const errorGlobalDel = document.getElementById("error-global-del");
const errorDelPassword = document.getElementById("error-del-password");

const toggleInfoEdition = () =>
{
    const globalErr = document.getElementById("error-global-info");
    if (globalErr) globalErr.textContent = "";

    formInfo.elements['user'].value = username.textContent;
    formInfo.elements['email'].value = email.textContent;

    btnInfo.classList.toggle("hidden");
    info.classList.toggle("hidden");
    editionInfo.classList.toggle("hidden");
};

const toggleSecEdition = () =>
{
    const globalErr = document.getElementById("error-global-security");
    if (globalErr) globalErr.textContent = "";

    btnSec.classList.toggle("hidden");
    sec.classList.toggle("hidden");
    editionSec.classList.toggle("hidden");
};

const openDialog = () => dialog.showModal();
const closeDialog = () =>
{
    dialog.close();
    if (errorGlobalDel) errorGlobalDel.textContent = "";
    if (errorDelPassword) errorDelPassword.textContent = "";
    delPassword.classList.remove("has-error");
};

const deleteAccount = async (e) =>
{
    e.preventDefault();

    errorGlobalDel.textContent = "";
    errorDelPassword.textContent = "";
    delPassword.classList.remove("has-error");

    spinnerDel.classList.remove("hidden");
    submitDel.disabled = true;

    try
    {
        const formData = new FormData(formDel);
        const response = await fetch("/api/delete.php",
        {
            method: "POST",
            body: formData,
            headers:
            {
                "X-Requested-With": "XMLHttpRequest"
            }
        });

        const data = await response.json();

        if (data.redirect)
        {
            window.location.href = data.redirect;
            return;
        }

        if (data.message)
            errorGlobalDel.textContent = data.message;

        if (data.errors && typeof data.errors === "object")
        {
            const passErr = data.errors.password || data.errors['del-password'];
            if (passErr && errorDelPassword)
            {
                errorDelPassword.textContent = passErr;
                delPassword.classList.add("has-error");
            }
        }
    }
    catch (error)
    {
        errorGlobalDel.textContent = error.message || "Error";
    }
    finally
    {
        spinnerDel.classList.add("hidden");
        submitDel.disabled = false;
    }
};

btnInfo.addEventListener("click", toggleInfoEdition);
btnSec.addEventListener("click", toggleSecEdition);
cancelInfo.addEventListener("click", toggleInfoEdition);
cancelSec.addEventListener("click", toggleSecEdition);
btnDel.addEventListener("click", openDialog);
cancelDel.addEventListener("click", closeDialog);
formDel.addEventListener("submit", deleteAccount);

/* On info update success: update DOM and exit edit mode */
if (formInfo)
{
    formInfo.addEventListener("ajax:success", () =>
    {
        const newUser = formInfo.elements['user'].value;
        if (newUser && username)
            username.textContent = newUser;

        btnInfo.classList.remove("hidden");
        info.classList.remove("hidden");
        editionInfo.classList.add("hidden");
    });
}

/* On security update success: clear inputs and exit edit mode */
if (editionSec)
{
    editionSec.addEventListener("ajax:success", () =>
    {
        editionSec.reset();
        btnSec.classList.remove("hidden");
        sec.classList.remove("hidden");
        editionSec.classList.add("hidden");
    });
}

if (notiCheckbox && formPref)
{
    notiCheckbox.addEventListener("change", () =>
    {
        if (typeof formPref.requestSubmit === "function")
            formPref.requestSubmit();
        else
            formPref.dispatchEvent(new Event("submit", { cancelable: true, bubbles: true }));
        notiCheckbox.disabled = true;
    });

    formPref.addEventListener("ajax:success", () => notiCheckbox.disabled = false);
    formPref.addEventListener("ajax:error", () => notiCheckbox.disabled = false);
}