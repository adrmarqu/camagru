<nav id="nav-mobile" class="mobile">
    <button id="burger">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div id="drop" class="dropdown">
        <a class="nav-item" href="<?= $galleryUrl ?>"><?= $galleryNav ?></a>
        <a class="nav-item" href="<?= $editorUrl ?>"><?= $editorNav ?></a>
        <button class="nav-item"><?= $username ?></button>
        <div>
            <a class="nav-item" href="<?= $profileUrl ?>"><?= $profileNav ?></a>
            <a class="nav-item" href="<?= $privateUrl ?>"><?= $privateNav ?></a>
            <a class="nav-item" href="<?= $favoriteUrl ?>"><?= $favoriteNav ?></a>
        </div>
        <button class="nav-item"><?= $language ?></button>
        <div>
            <a class="nav-item" href="/en/<?= $pageName ?>"><?= $en ?></a>
            <a class="nav-item" href="/es/<?= $pageName ?>"><?= $es ?></a>
            <a class="nav-item" href="/ca/<?= $pageName ?>"><?= $ca ?></a>
        </div>
    </div>
    <form action="/api/logout.php" method="POST">
        <button type="submit" class="btn-logout"><?= $logoutNav ?></button>
    </form>
</nav>