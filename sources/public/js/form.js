const passwordEye = () =>
{
    document.querySelectorAll('.btn-toggle-pass').forEach(btn => 
    {
        btn.setAttribute('tabindex', '-1');
    });

    document.addEventListener('click', (e) => 
    {
        const toggleBtn = e.target.closest('.btn-toggle-pass');
        if (!toggleBtn) return;

        // Find associated password input within wrapper or via attribute
        const wrapper = toggleBtn.closest('.password-wrapper') || toggleBtn.parentElement;
        const targetId = toggleBtn.getAttribute('aria-controls') || toggleBtn.dataset.target;
        const input = targetId ? document.getElementById(targetId) : wrapper?.querySelector('input');

        if (input)
        {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            toggleBtn.textContent = isPassword ? '👁️' : '🙈';
            toggleBtn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        }
    });
};

const clearErrors = (form, globalError) =>
{
    if (globalError)
    {
        globalError.textContent = '';
        globalError.classList.remove('success');
    }
    
    form.querySelectorAll('.field-error').forEach(span => 
    {
        span.textContent = '';
    });
    form.querySelectorAll('.has-error').forEach(input =>
    {
        input.classList.remove('has-error');
    });
};

/* Track which fields have been modified since last error */
const modifiedFields = new Set();

const trackModifications = (form) =>
{
    form.querySelectorAll('input, select, textarea').forEach(input =>
    {
        if (input._hasTracker) return;
        input._hasTracker = true;

        const fieldName = input.name || input.id;
        if (!fieldName) return;

        const handler = () => modifiedFields.add(fieldName);
        input.addEventListener('input', handler);
        input.addEventListener('change', handler);
    });
};

/* Check if there are unresolved errors (fields with errors that haven't been touched) */
const hasUnresolvedErrors = (form) =>
{
    const errorSpans = form.querySelectorAll('.field-error');
    let hasUnresolved = false;

    errorSpans.forEach(span =>
    {
        if (!span.textContent.trim()) return;

        // Get the field name from the span id (error-<fieldname>)
        const fieldName = span.id?.replace('error-', '');
        if (!fieldName) return;

        if (!modifiedFields.has(fieldName))
        {
            hasUnresolved = true;

            // Shake animation on the error span
            span.classList.remove('shake');
            void span.offsetWidth;
            span.classList.add('shake');

            // Also shake the input
            const input = form.querySelector(`[name="${fieldName}"], #${fieldName}`);
            if (input)
            {
                input.classList.remove('shake');
                void input.offsetWidth;
                input.classList.add('shake');
            }
        }
    });

    return hasUnresolved;
};

document.addEventListener('DOMContentLoaded', () =>
{
    passwordEye();

    document.addEventListener('submit', async (e) =>
    {
        const form = e.target;
        if (!form.matches('.ajax-form, #form')) return;

        e.preventDefault();

        // Track field modifications
        trackModifications(form);

        // Scope elements relative to the submitted form
        const container = form.closest('section, div, main') || document;
        const globalError = form.querySelector('.error-message') 
            || container.querySelector('.error-container .error-message, #error-global') 
            || document.getElementById('error-global');

        // Check for unresolved errors before submitting
        if (hasUnresolvedErrors(form))
            return;

        const btnSubmit = form.querySelector('button[type="submit"], input[type="submit"]') || document.getElementById('btn-submit');
        const btnSpinner = btnSubmit?.querySelector('.btn-spinner');

        clearErrors(form, globalError);

        // Set loading state
        if (btnSubmit) btnSubmit.disabled = true;
        if (btnSpinner) btnSpinner.classList.remove('hidden');

        const formData = new FormData(form);
        const targetUrl = form.getAttribute('action') || '/api/form.php';

        try
        {
            const response = await fetch(targetUrl,
            {
                method: form.method || 'POST',
                body: formData,
                headers: 
                {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            // Redirect if present (takes absolute priority)
            if (data.redirect)
            {
                window.location.href = data.redirect;
                return;
            }

            // Global message
            if (data.message && globalError)
            {
                globalError.textContent = data.message;
                if (data.success)
                    globalError.classList.add('success');
                else
                    globalError.classList.remove('success');
            }

            // Field-specific errors (processed independently of message)
            if (data.errors && typeof data.errors === 'object')
            {
                // Reset modified tracking for new errors
                modifiedFields.clear();
                trackModifications(form);

                Object.entries(data.errors).forEach(([field, msg]) =>
                {
                    const errorSpan = form.querySelector(`#error-${field}`) 
                        || container.querySelector(`#error-${field}`) 
                        || document.getElementById(`error-${field}`);
                    
                    const inputElem = form.querySelector(`[name="${field}"], #${field}`) 
                        || document.getElementById(field);

                    if (errorSpan)
                        errorSpan.textContent = msg;
                    
                    if (inputElem)
                        inputElem.classList.add('has-error');
                });
            }

            if (data.success)
            {
                form.dispatchEvent(new CustomEvent('ajax:success', { detail: data }));
            }
            else
            {
                form.dispatchEvent(new CustomEvent('ajax:error', { detail: data }));
            }
        } 
        catch (error)
        {
            if (globalError) 
                globalError.textContent = error;
        }
        finally 
        {
            // Reset loading state
            if (btnSubmit) btnSubmit.disabled = false;
            if (btnSpinner) btnSpinner.classList.add('hidden');
        }
    });
});
