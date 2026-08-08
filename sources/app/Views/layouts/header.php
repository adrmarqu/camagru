<!-- Left part -->
<!-- Logo PC -->

<a id="logo" class="pc" href="<?= $galleryUrl ?>">
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

<!-- Burger Mobile -->

<button id="burger" class="mobile hidden">
    <span></span>
    <span></span>
    <span></span>
</button>

<!-- Right part -->
<!-- Guest PC -->

<?php $dropLangLink = PARTIAL_TPL . '/dropdown-lang.php' ?>

<?php if (Auth::check() === false): ?>

<nav class="pc nav-pc">
    <?php require $dropLangLink ?>
    
    <a class="nav-item" href="<?= $loginUrl ?>"><?= $login ?></a>
    <a class="nav-item" href="<?= $signinUrl ?>"><?= $signin ?></a>
</nav>

<!-- Guest Mobile -->

<div class="mobile dropdown drop">
    <a class="nav-item" href="<?= $loginUrl ?>"><?= $login ?></a><hr>
    <a class="nav-item" href="<?= $signinUrl ?>"><?= $signin ?></a><hr>

    <?php require $dropLangLink ?>
</div>

<?php else: ?>

<!-- User PC -->

<nav class="pc nav-pc">
    <a class="nav-item" href="<?= $galleryUrl ?>"><?= $gallery ?></a>
    <a class="nav-item" href="<?= $editorUrl ?>"><?= $editor ?></a>
    
    <button class="nav-item"><?= Auth::username() ?></button>
    <div id="drop-user" class="dropdown">
        <a class="nav-item" href="<?= $profileUrl ?>"><?= $profile ?></a>
        <a class="nav-item" href="<?= $favUrl ?>"><?= $fav ?></a>
        <a class="nav-item" href="<?= $privateUrl ?>"><?= $private ?></a>

        <?php require $dropLangLink ?>
    </div>
</nav>

<!-- User Mobile -->

<div class="mobile dropdown drop">
    <a class="nav-item" href="<?= $galleryUrl ?>"><?= $gallery ?></a>
    <a class="nav-item" href="<?= $editorUrl ?>"><?= $editor ?></a>
    
    <button class="nav-item"><?= Auth::username() ?></button>
    <div>
        <a class="nav-item" href="<?= $profileUrl ?>"><?= $profile ?></a>
        <a class="nav-item" href="<?= $favUrl ?>"><?= $fav ?></a>
        <a class="nav-item" href="<?= $privateUrl ?>"><?= $private ?></a>
    </div>

    <?php require $dropLangLink ?>
</div>

<!-- Logout -->

<form
    action="/api/logout.php"
    class="ajax-form"
    method="POST"
    data-redirect="<?= $galleryUrl ?>"
>
    <button type="submit" class="btn-logout">
        <?= Lang::t('header.logout') ?>
    </button>
</form>

<?php endif; ?>
