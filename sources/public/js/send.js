const btn = document.getElementById("btn-send");
const error = document.getElementById("error-global");

const originalText = btn.textContent;
const waitingTime = 5;

function startTimer(seconds)
{
    btn.disabled = true;
    
    const interval = setInterval(() =>
    {
        seconds--;
        
        btn.textContent = `${originalText} (${seconds}s)`;

        if (seconds <= 0)
        {
            clearInterval(interval);
            btn.textContent = originalText;
            btn.disabled = false;
        }
    }, 1000);
}

const sendEmail = async () =>
{
    btn.disabled = true;
    error.textContent = "";

    try
    {
        const response = await fetch('/api/sendEmail.php',
        {
            method: 'POST',
            headers:
            {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (!response.ok)
            throw new Error(data.message || 'Error');

        startTimer(waitingTime);
    }
    catch (err)
    {
        error.textContent = err.message;
        btn.disabled = false;
    }
};

btn.addEventListener("click", sendEmail);

startTimer(waitingTime);