<?php $resType = $_GET['type']; ?>

<section>
    <h1><?= Lang::t("email.$resType.title") ?></h1>
    <p><?= Lang::t("result.$resType") ?></p>
    
    <!-- Activate account -->
    <?php if ($resType === 'account'): ?>
        
        <a href="<?= $loginUrl ?>">
            <?= Lang::t('btn.login') ?>
        </a>

    <!-- Confirm new email -->
    <?php elseif ($resType === 'email'): ?>

        <a href="<?= $profileUrl ?>">
            <?= Lang::t('btn.profile') ?>
        </a>

    <!-- Restore password (from login) -->
    <?php else: ?>

        <a href="<?= $loginUrl ?>">
            <?= Lang::t('btn.login') ?>
        </a>

    <?php endif; ?>
</section>