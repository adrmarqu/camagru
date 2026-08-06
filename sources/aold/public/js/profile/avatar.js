document.addEventListener('DOMContentLoaded', () => {
    const img = document.getElementById("big-avatar");
    const btnAvatar = document.getElementById("btn-avatar");
    const btnOverlay = document.getElementById("btn-avatar-overlay");
    const input = document.getElementById("input-avatar");
    const form = document.getElementById("form-avatar");
    const errorMsg = document.getElementById("error-avatar");

    const triggerUpload = () => {
        if (input) input.click();
    };

    if (btnAvatar) btnAvatar.addEventListener("click", triggerUpload);
    if (btnOverlay) btnOverlay.addEventListener("click", triggerUpload);

    if (input && form) {
        input.addEventListener("change", () => {
            if (input.files && input.files.length > 0) {
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit();
                } else {
                    form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                }
            }
        });

        form.addEventListener('ajax:success', (e) => {
            const data = e.detail;
            if (data && (data.url || data.avatarUrl)) {
                if (img) img.src = data.url || data.avatarUrl;
            }
            if (errorMsg) errorMsg.textContent = '';
        });

        form.addEventListener('ajax:error', (e) => {
            const data = e.detail;
            if (data && data.error && errorMsg) {
                errorMsg.textContent = data.error;
            }
        });
    }
});