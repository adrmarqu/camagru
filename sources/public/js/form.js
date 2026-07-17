const form = document.getElementById("form");
const global = document.getElementById("error-global");

const submitForm = (e) =>
{
    e.preventDefault();

    /* Clean all span */
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
            }
        }
    })
    .catch(error =>
    {
        /* Internal error */
        global.textContent = error.message;
    });
};

form.addEventListener("submit", submitForm);