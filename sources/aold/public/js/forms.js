document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form.ajax-form');

    forms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Clear previous errors
            const globalError = form.closest('section')?.querySelector('#error-global') || document.querySelector('#error-global');
            if (globalError) {
                globalError.textContent = '';
            }

            form.querySelectorAll('.input-error').forEach(input => {
                input.classList.remove('input-error');
            });
            form.querySelectorAll('span[id^="error-"]').forEach(span => {
                span.textContent = '';
            });

            const formData = new FormData(form);
            const action = form.getAttribute('action');
            const method = form.getAttribute('method') || 'POST';
            
            try {
                const response = await fetch(action, {
                    method: method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                let data;
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    data = await response.json();
                } else {
                    // Fallback if not JSON (server error etc.)
                    const text = await response.text();
                    console.error("Not a JSON response:", text);
                    if (globalError) {
                        globalError.textContent = "An unexpected error occurred.";
                    }
                    return;
                }

                if (data.success) {
                    // Dispatch success event
                    const event = new CustomEvent('ajax:success', { detail: data });
                    form.dispatchEvent(event);

                    // Check for data-redirect attribute or server response redirect
                    const redirectUrl = data.redirect || form.getAttribute('data-redirect');
                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    }
                } else {
                    // Dispatch error event
                    const event = new CustomEvent('ajax:error', { detail: data });
                    form.dispatchEvent(event);

                    // Display errors
                    if (data.global && globalError) {
                        globalError.textContent = data.global;
                    }
                    if (data.errors) {
                        for (const [field, message] of Object.entries(data.errors)) {
                            const errorSpan = form.querySelector(`#error-${field}`);
                            if (errorSpan) {
                                errorSpan.textContent = message;
                            }
                            
                            // Try to find the corresponding input to add input-error class
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('input-error');
                            }
                        }
                    }
                }
            } catch (error) {
                console.error('Fetch error:', error);
                if (globalError) {
                    globalError.textContent = 'A network error occurred. Please try again.';
                }
            }
        });
    });

    /* Remove error style when user starts typing */
    document.querySelectorAll('form.ajax-form input').forEach(input => {
        const event = input.type === 'checkbox' ? 'change' : 'input';

        input.addEventListener(event, function() {
            this.classList.remove('input-error');

            const errorSpan = document.getElementById(`error-${this.name}`);
            if (errorSpan) {
                errorSpan.textContent = '';
            }
        });
    });
});
