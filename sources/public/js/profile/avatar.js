const img = document.getElementById("big-avatar");
const btn = document.getElementById("btn-avatar");
const input = document.getElementById("input-avatar");
const errorMsg = document.getElementById("error-avatar");

const openInput = async () =>
{
    input.click();

    if (input.files.length === 0) return ;

    const formData = new FormData();

    formData.append('image', input.files[0]);

    try
    {
        const response = await fetch('/api/profile/avatar.php',
        {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        /* Wrong image format or other thing */
        if (data.success === false)
        {
            errorMsg.textContent = data.error;
            return ;
        }

        /* Success */
        img.src = data.url;
    }
    /* HTTP error */ 
    catch (error) { errorMsg.textContent = error; }
};

btn.addEventListener("click", openInput);