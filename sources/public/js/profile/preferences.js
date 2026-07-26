const errorMsg = document.getElementById("error-noti");
const form = document.getElementById("form-noti");
const input = document.getElementById("noti");
const loader = document.getElementById("loader");

const setMsg = (message, color) =>
{
    errorMsg.textContent = message;
    msgContainer.classList.add(color);
}

const handleNoti = async () =>
{
    try
    {
        const formData = new FormData(form);

        loader.classList.remove("hidden");

        const response = await fetch('/api/profile/noti.php',
        {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        loader.classList.add("hidden");

        if (data.success === false)
        {
            setMsg(data.error, "rojo");
            return ;
        }
        setMsg(data.msg, "verde");
    }
    catch (error) { setMsg(error, "rojo"); }
};

input.addEventListener("change", handleNoti);