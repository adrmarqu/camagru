<?php 

$resType = $_GET['type'] ?? 'account'; 
$titleKey = "email.$resType.title";
$title = Lang::t($titleKey);
if ($title === $titleKey) $title = Lang::t("title.$resType") ?? 'Resultado';

?>

<div class="result-container card">
    <div class="result-icon-wrapper">
        <div class="result-icon">✓</div>
    </div>

    <h1 class="result-title"><?= $title ?></h1>
    <p class="result-message"><?= Lang::t("result.$resType") ?></p>
    
    <div class="result-actions">
        <!-- Activate account -->
        <?php if ($resType === 'account'): ?>
            <a href="<?= $loginUrl ?>" class="result-link">
                <?= Lang::t('btn.login') ?>
            </a>
        <!-- Confirm new email -->
        <?php elseif ($resType === 'email'): ?>
            <a href="<?= $profileUrl ?>" class="result-link">
                <?= Lang::t('btn.profile') ?>
            </a>
        <!-- Restore password (from login) -->
        <?php else: ?>
            <a href="<?= $loginUrl ?>" class="result-link">
                <?= Lang::t('btn.login') ?>
            </a>
        <?php endif; ?>
    </div>
</div>