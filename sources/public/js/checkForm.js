const output = document.getElementById("form-msg");

const checkForm = (e) =>
{
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    formData.append("formName", form.type.value);

    fetch("/api/validateFormJs.php", 
    {
        method: "POST",
        body: formData
    })
    .then(async res => {
        const text = await res.text();
        console.log("RAW RESPONSE:", text);
        return JSON.parse(text);
    })
    .then(data => 
    {
        console.log(data);
        if (!data.success)
        {
            output.innerHTML = data.message;
            return ;
        }
        form.submit();
    })
    .catch(err => console.error('ERROR:', err));
}

document.addEventListener('submit', checkForm);