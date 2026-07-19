const form = document.getElementById("form");
const global = document.getElementById("error-global");

const submitForm = (e) =>
{
    e.preventDefault();

    /* Check for inputs with errors */
    const errorInputs = form.querySelectorAll('.input-error');
    if (errorInputs.length > 0)
    {
        errorInputs.forEach(input =>
        {
            input.classList.remove('input-shake');
            void input.offsetWidth;
            input.classList.add('input-shake');
        });
        return;
    }

    /* Clean all errors */
    document.querySelectorAll('[id^="error-"]').forEach(span => span.textContent = "");

    const formData = new FormData(form);

    fetch("/api/checkForm.php",
    {
        method: "POST",
        body: formData
    })
    .then(response =>
    {
        if (!response.ok)
        {
            if (response.headers.get('content-type')?.includes('application/json'))
            {
                return response.json();
            }
            throw new Error(`Server error: ${response.status} ${response.statusText}`);
        }
        return response.json();
    })
    .then(data =>
    {
        if (data.success)
            form.submit();
        else
        {
            /* Print error messages */
            for (const [key, msg] of Object.entries(data.errors))
            {
                const span = document.getElementById(`error-${key}`);
                if (span)
                    span.textContent = msg;

                const input = document.getElementById(key);
                if (input)
                    input.classList.add('input-error');
            }
        }
    })
    .catch(error =>
    {
        global.textContent = error.message;
    });
};

form.addEventListener("submit", submitForm);

/* Remove error style when user starts typing */
form.querySelectorAll('input').forEach(input =>
{
    const event = input.type === 'checkbox' ? 'change' : 'input';

    input.addEventListener(event, function()
    {
        this.classList.remove('input-error');

        const errorSpan = document.getElementById(`error-${this.id}`);
        if (errorSpan)
            errorSpan.textContent = '';
    });
});
