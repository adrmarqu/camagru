<meta charset="UTF-8">
<title><?= $title ?? 'Camagru' ?></title>
<link rel="icon" href="/assets/logo.webp" type="image/webp">

<link rel="stylesheet" href="<?= URL_CSS . '/app.css' ?>?v1">
<link rel="stylesheet" href="<?= URL_CSS . '/header.css' ?>?v1">

<?php foreach ($css ?? [] as $file): ?>
    <link rel="stylesheet" href="<?= URL_CSS . $file ?>?v1">
<?php endforeach; ?>