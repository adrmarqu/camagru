document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById("form-noti");
    const input = document.getElementById("noti");
    const loader = document.getElementById("loader");
    const successMsg = document.getElementById("global-noti");

    if (!form || !input) return;

    input.addEventListener("change", () => {
        if (loader) loader.classList.remove("hidden");
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
        } else {
            form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
        }
    });

    form.addEventListener('ajax:success', (e) => {
        if (loader) loader.classList.add("hidden");
        const data = e.detail || {};
        if (successMsg && data.msg) {
            successMsg.textContent = data.msg;
            setTimeout(() => { successMsg.textContent = ''; }, 3000);
        }
    });

    form.addEventListener('ajax:error', () => {
        if (loader) loader.classList.add("hidden");
    });
});