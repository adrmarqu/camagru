<div class="pc">
<a id="logo" href="<?= $galleryUrl ?>">
    <svg 
        xmlns="http://www.w3.org/2000/svg"
        viewBox="6.5 8.5 29 23"
        width="42"
        height="42"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
        stroke-linejoin="round">

        <!-- Camera body -->
        <rect x="7" y="11" width="28" height="20" rx="4"/>

        <!-- Upper part -->
        <path d="M13 11l2-3h12l2 3"/>

        <!-- Camera -->
        <circle cx="21" cy="21" r="6"/>

        <!-- Obturator -->
        <circle cx="21" cy="21" r="2.2"/>

        <!-- Flash -->
        <circle cx="30" cy="16" r="1"/>
        
    </svg>
    <span>Camagru</span>
</a>

<nav id="nav-pc">
    <button class="nav-item"><?= $language ?></button>
    <div id="drop-lang" class="dropdown">
        <a class="nav-item" href="/en/<?= $pageName ?>"><?= $en ?></a>
        <a class="nav-item" href="/es/<?= $pageName ?>"><?= $es ?></a>
        <a class="nav-item" href="/ca/<?= $pageName ?>"><?= $ca ?></a>
    </div>
    <a class="nav-item" href="<?= $loginUrl ?>"><?= $loginNav ?></a>
    <a class="nav-item" href="<?= $signinUrl ?>"><?= $signinNav ?></a>
</nav>
</div>
