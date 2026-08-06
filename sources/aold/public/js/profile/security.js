document.addEventListener('DOMContentLoaded', () => {
    const info = document.getElementById("security");
    const editBtn = document.getElementById("btn-pass");
    const form = document.getElementById("form-pass");
    if (!form || !info || !editBtn) return;

    const cancelBtn = form.querySelector('button[name="cancel"]');
    const successMsg = document.getElementById("global-sec");

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
        form.reset();
        
        // Clear error styles and text
        form.querySelectorAll('.input-error').forEach(input => input.classList.remove('input-error'));
        form.querySelectorAll('span[id^="error-"]').forEach(span => span.textContent = '');
        if (successMsg) successMsg.textContent = '';
        
        toggleEdit(false);
    };

    editBtn.addEventListener("click", () => {
        toggleEdit(true);
    });

    if (cancelBtn) {
        cancelBtn.addEventListener("click", cancelEdit);
    }

    form.addEventListener('ajax:success', (e) => {
        const data = e.detail || {};
        form.reset();
        toggleEdit(false);

        if (successMsg && data.msg) {
            successMsg.textContent = data.msg;
            setTimeout(() => { successMsg.textContent = ''; }, 4000);
        }
    });
});