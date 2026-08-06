document.addEventListener('DOMContentLoaded', () => {
    const dialog = document.getElementById("dialog-del");
    const btnDel = document.getElementById("btn-del");
    const form = document.getElementById("form-del");
    if (!dialog || !btnDel || !form) return;

    const cancelBtn = document.getElementById("btn-del-cancel") || form.querySelector('button[name="cancel"]');

    const openDialog = () => {
        if (typeof dialog.showModal === 'function') {
            dialog.showModal();
        } else {
            dialog.setAttribute('open', 'true');
        }
    };

    const closeDialog = () => {
        form.reset();
        
        // Clear errors
        form.querySelectorAll('.input-error').forEach(input => input.classList.remove('input-error'));
        form.querySelectorAll('span[id^="error-"]').forEach(span => span.textContent = '');
        
        if (typeof dialog.close === 'function') {
            dialog.close();
        } else {
            dialog.removeAttribute('open');
        }
    };

    btnDel.addEventListener("click", openDialog);

    if (cancelBtn) {
        cancelBtn.addEventListener("click", closeDialog);
    }

    form.addEventListener('ajax:success', (e) => {
        const data = e.detail || {};
        closeDialog();
        if (data.redirect) {
            window.location.href = data.redirect;
        } else {
            window.location.href = '/login';
        }
    });
});