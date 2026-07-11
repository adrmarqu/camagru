<nav id="nav-mobile" class="mobile">
    <button id="burger">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div id="drop" class="dropdown">
        <a class="nav-item" href="<?= $pages['gallery'] ?>"><?= $header['gallery'] ?></a>
        <a class="nav-item" href="<?= $pages['editor'] ?>"><?= $header['editor'] ?></a>
        <button class="nav-item"><?= $glob['username'] ?></button>
        <div>
            <a class="nav-item" href="<?= $pages['profile'] ?>"><?= $header['profile'] ?></a>
            <a class="nav-item" href="<?= $pages['private'] ?>"><?= $header['private'] ?></a>
            <a class="nav-item" href="<?= $pages['favorite'] ?>"><?= $header['favorite'] ?></a>
        </div>
        <button class="nav-item"><?= $header['language'] ?></button>
        <div>
            <a class="nav-item" href="/en/<?= $page ?>"><?= $header['en'] ?></a>
            <a class="nav-item" href="/es/<?= $page ?>"><?= $header['es'] ?></a>
            <a class="nav-item" href="/ca/<?= $page ?>"><?= $header['ca'] ?></a>
        </div>
    </div>
    <button class="btn-logout"><?= $header['logout'] ?></button>
</nav>