<section>
    <h1><?= $titlePage ?></h1>
    <p><?= $body ?></p>
    <a href="<?= $action === 'account' ? $loginUrl : $profileUrl ?>">
        <?= $btnCont ?>
    </a>
</section>