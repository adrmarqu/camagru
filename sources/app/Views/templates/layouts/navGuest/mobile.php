<nav class="mobile">
    <button id="burger">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div id="drop" class="dropdown">
        <a class="nav-item" href="<?= $loginUrl ?>"><?= $loginNav ?></a>
        <hr style="width: 100%;">
        <a class="nav-item" href="<?= $signinUrl ?>"><?= $signinNav ?></a>
        <button class="nav-item"><?= $language ?></button>
        <div id="drop-lang" class="dropdown">
            <a class="nav-item" href="/en/<?= $pageName ?>"><?= $en ?></a>
            <a class="nav-item" href="/es/<?= $pageName ?>"><?= $es ?></a>
            <a class="nav-item" href="/ca/<?= $pageName ?>"><?= $ca ?></a>
        </div>
    </div>
</nav>
