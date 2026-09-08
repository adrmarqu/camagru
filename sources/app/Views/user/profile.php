<?php $dir = __DIR__; ?>

<div class="profile-container">
    <header class="profile-header">
        <h1><?= Lang::t('title.profile') ?></h1>
        <hr>
    </header>

    <div id="profile-cont-1">
        <?php require_once $dir . '/stats.php'; ?>
        <div class="profile-info-col">
            <?php require_once $dir . '/info.php'; ?>
            <?php require_once $dir . '/security.php'; ?>
        </div>
    </div>
    <div id="profile-cont-2">
        <?php require_once $dir . '/preferences.php'; ?>
        <?php require_once $dir . '/danger.php'; ?>
    </div>
</div>