<?php $isMobile = $isMobile ?? false; ?>

<!-- Inside the burger -->
<?php if ($isMobile): ?>

<span class="nav-lang-label"><?= Lang::t('header.languages') ?></span>

<div class="drop-lang">
    <a 
        class="nav-item <?= $lang === 'en' ? 'lang-active' : '' ?>" 
        href="/en/<?= $page ?>"
    >
        <?php if ($lang === 'en'): ?><span class="lang-check">✓</span><?php endif;?>
        <?= Lang::t('en') ?>
    </a>
    <a
        class="nav-item <?= $lang === 'es' ? 'lang-active' : '' ?>" 
        href="/es/<?= $page ?>"
    >
        <?php if ($lang === 'es'): ?><span class="lang-check">✓</span><?php endif;?>
        <?= Lang::t('es') ?>
    </a>
    <a 
        class="nav-item <?= $lang === 'ca' ? 'lang-active' : '' ?>" 
        href="/ca/<?= $page ?>"
    >
        <?php if ($lang === 'ca'): ?><span class="lang-check">✓</span><?php endif;?>
        <?= Lang::t('ca') ?>
    </a>
</div>

<!-- Outside the burger -->
<?php else: ?>

<button class="nav-item"><?= Lang::t($lang) ?></button>
<div class="dropdown drop-lang">
    <a class="nav-item <?= $lang === 'en' ? 'lang-active' : '' ?>" href="/en/<?= $page ?>"><?= Lang::t('en') ?></a>
    <a class="nav-item <?= $lang === 'es' ? 'lang-active' : '' ?>" href="/es/<?= $page ?>"><?= Lang::t('es') ?></a>
    <a class="nav-item <?= $lang === 'ca' ? 'lang-active' : '' ?>" href="/ca/<?= $page ?>"><?= Lang::t('ca') ?></a>
</div>

<?php endif; ?>