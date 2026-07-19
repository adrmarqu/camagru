<meta charset="UTF-8">
<title><?= $title ?? 'Camagru' ?></title>
<link rel="icon" href="/assets/logo.webp" type="image/webp">

<link rel="stylesheet" href="<?= URL_CSS . '/app.css' ?>?v=<?= filemtime(PUBLIC_PATH . '/css/app.css') ?>">
<link rel="stylesheet" href="<?= URL_CSS . '/header.css' ?>?v=<?= filemtime(PUBLIC_PATH . '/css/header.css') ?>">

<?php foreach ($css ?? [] as $file): ?>
    <link rel="stylesheet" href="<?= URL_CSS . $file ?>?v=<?= filemtime(PUBLIC_PATH . '/css' . $file) ?>">
<?php endforeach; ?>