const burger     = document.getElementById('burger');
const mobileMenu = document.querySelector('.mobile.dropdown.drop'); // guest or user

// ---- Close all dropdowns ----
function closeAll()
{
    document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
    burger?.classList.remove('open');
    mobileMenu?.classList.remove('show');
}

// ---- Clicks dentro del burger no cierran el menú ----
mobileMenu?.addEventListener('click', (e) => {
    e.stopPropagation();
});

// ---- Burger (mobile menu) ----
burger?.addEventListener('click', (e) =>
{
    e.stopPropagation();
    
    const opening = !mobileMenu.classList.contains('show');
    
    closeAll();
    
    if (opening)
    {
        mobileMenu.classList.add('show');
        burger.classList.add('open');
    }
});

// ---- PC Dropdowns ----
// Get all buttons of .nav-pc where nextElementSibling is .dropdown
document.querySelectorAll('.nav-pc button.nav-item').forEach(btn =>
{
    const drop = btn.nextElementSibling;
    if (!drop?.classList.contains('dropdown')) return;

    btn.addEventListener('click', (e) =>
    {
        e.stopPropagation();
        const wasOpen = drop.classList.contains('show');

        // Close dropdowns
        document.querySelectorAll('.dropdown.show').forEach(d =>
        {
            if (!d.contains(btn)) d.classList.remove('show');
        });

        if (!wasOpen) drop.classList.add('show');
    });
});

// ---- Click fuera → cerrar todo ----
document.addEventListener('click', closeAll);

// ---- Logout ----
const logoutForm = document.getElementById('logout-form') || document.querySelector('form[action="/api/logout.php"]');
logoutForm?.addEventListener('submit', async (e) =>
{
    e.preventDefault();

    const submitBtn = logoutForm.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;

    try
    {
        const response = await fetch(logoutForm.action,
        {
            method: logoutForm.method || 'POST',
            headers:
            {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data && data.redirect)
        {
            window.location.href = data.redirect;
            return;
        }

        window.location.href = logoutForm.dataset.redirect || '/';
    }
    catch (error)
    {
        window.location.href = logoutForm.dataset.redirect || '/';
    }
    finally
    {
        if (submitBtn) submitBtn.disabled = false;
    }
});