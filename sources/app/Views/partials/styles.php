<!-- Common styles -->

<link rel="stylesheet" href="<?= URL_CSS . '/common/app.css' ?>?v=<?= filemtime(PUBLIC_PATH . '/css/common/app.css') ?>">
<link rel="stylesheet" href="<?= URL_CSS . '/common/styles.css' ?>?v=<?= filemtime(PUBLIC_PATH . '/css/common/styles.css') ?>">
<link rel="stylesheet" href="<?= URL_CSS . '/common/header.css' ?>?v=<?= filemtime(PUBLIC_PATH . '/css/common/header.css') ?>">
<link rel="stylesheet" href="<?= URL_CSS . '/common/footer.css' ?>?v=<?= filemtime(PUBLIC_PATH . '/css/common/footer.css') ?>">

<!-- Particular styles -->
<?php foreach ($css ?? [] as $file): ?>
    <link rel="stylesheet" href="<?= URL_CSS . $file ?>?v=<?= filemtime(PUBLIC_PATH . '/css' . $file) ?>">
<?php endforeach; ?>