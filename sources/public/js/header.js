document.addEventListener("DOMContentLoaded", () => 
{
    document.addEventListener("click", (e) =>
    {
        const burger = document.getElementById("burger");
        const dropMobile = document.getElementById("drop");
        
        // Handle burger click
        const isBurger = e.target.closest('#burger');
        if (isBurger && burger && dropMobile)
        {
            burger.classList.toggle("open");
            dropMobile.classList.toggle("open");
            
            // If closing burger, also close nested dropdowns
            if (!burger.classList.contains("open"))
            {
                dropMobile.querySelectorAll('.open').forEach(el => 
                {
                    el.classList.remove('open');
                });
            }
            return;
        }

        // Handle dropdown toggle buttons
        const toggleBtn = e.target.closest('button.nav-item');
        if (toggleBtn)
        {
            const nextEl = toggleBtn.nextElementSibling;
            if (nextEl && (nextEl.classList.contains('dropdown') 
                || nextEl.tagName === 'DIV'))
            {
                nextEl.classList.toggle('open');
                
                // If closing dropdown, also close its nested dropdowns
                if (!nextEl.classList.contains('open'))
                {
                    nextEl.querySelectorAll('.open').forEach(el => 
                    {
                        el.classList.remove('open');
                    });
                }
                return;
            }
        }

        // Handle click outside open menus
        // We only close everything if the click is outside any element with the 'open' class
        // (meaning we clicked the background or another non-dropdown part of the page)
        if (!e.target.closest('.open'))
        {
            if (burger) burger.classList.remove("open");

            document.querySelectorAll(".open").forEach(el => 
            {
                el.classList.remove("open");
            });
        }
    });
});