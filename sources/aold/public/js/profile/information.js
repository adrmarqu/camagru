document.addEventListener('DOMContentLoaded', () => {
    const info = document.getElementById("information");
    const editBtn = document.getElementById("btn-info");
    const form = document.getElementById("form-info");
    if (!form || !info || !editBtn) return;

    const cancelBtn = form.querySelector('button[name="cancel"]');
    const userVal = document.getElementById("user-val");
    const emailVal = document.getElementById("email-val");
    const msgContainer = form.querySelector(".form-container");
    const successMsg = document.getElementById("global-info");

    let originalUser = form.user ? form.user.value : '';
    let originalEmail = form.email ? form.email.value : '';

    const toggleEdit = (showForm) => {
        if (showForm) {
            info.classList.add("hidden");
            editBtn.classList.add("hidden");
            form.classList.remove("hidden");
        } else {
            info.classList.remove("hidden");
            editBtn.classList.remove("hidden");
            form.classList.add("hidden");
        }
    };

    const cancelEdit = () => {
        if (form.user) form.user.value = originalUser;
        if (form.email) form.email.value = originalEmail;
        
        // Clear errors
        form.querySelectorAll('.input-error').forEach(input => input.classList.remove('input-error'));
        form.querySelectorAll('span[id^="error-"]').forEach(span => span.textContent = '');
        if (successMsg) successMsg.textContent = '';
        
        toggleEdit(false);
    };

    editBtn.addEventListener("click", () => {
        if (form.user) originalUser = userVal ? userVal.textContent.trim() : form.user.value;
        if (form.email) originalEmail = emailVal ? emailVal.textContent.trim() : form.email.value;
        toggleEdit(true);
    });

    if (cancelBtn) {
        cancelBtn.addEventListener("click", cancelEdit);
    }

    form.addEventListener('ajax:success', (e) => {
        const data = e.detail || {};
        const newUser = form.user ? form.user.value : (data.user || originalUser);
        const newEmail = form.email ? form.email.value : (data.email || originalEmail);

        originalUser = newUser;
        originalEmail = newEmail;

        if (userVal) userVal.textContent = newUser;
        if (emailVal) emailVal.textContent = newEmail;

        toggleEdit(false);

        if (successMsg && data.msg) {
            successMsg.textContent = data.msg;
            setTimeout(() => { successMsg.textContent = ''; }, 4000);
        }
    });
});