<div class="pc">
    <a id="logo" href="<?= $pages['gallery'] ?>">
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
        <a class="nav-item" href="<?= $pages['gallery'] ?>"><?= $header['gallery'] ?></a>
        <a class="nav-item" href="<?= $pages['editor'] ?>"><?= $header['editor'] ?></a>
        <button class="nav-item"><?= $glob['username'] ?></button>
        <div id="drop-user" class="dropdown">
            <a class="nav-item" href="<?= $pages['profile'] ?>"><?= $header['profile'] ?></a>
            <a class="nav-item" href="<?= $pages['private'] ?>"><?= $header['private'] ?></a>
            <a class="nav-item" href="<?= $pages['favorite'] ?>"><?= $header['favorite'] ?></a>
            <button class="nav-item"><?= $header['language'] ?></button>
            <div id="drop-lang" class="dropdown">
                <a class="nav-item" href="/en/<?= $page ?>"><?= $header['en'] ?></a>
                <a class="nav-item" href="/es/<?= $page ?>"><?= $header['es'] ?></a>
                <a class="nav-item" href="/ca/<?= $page ?>"><?= $header['ca'] ?></a>
            </div>
        </div>
        <button class="btn-logout"><?= $header['logout'] ?></button>
    </nav>
</div>