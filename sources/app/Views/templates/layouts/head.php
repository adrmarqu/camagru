<meta charset="UTF-8">
<title><?= $title ?? 'Camagru' ?></title>
<link rel="icon" href="/assets/logo.webp" type="image/webp">

<?php foreach ($global['css'] ?? [] as $file): ?>
    <link rel="stylesheet" href="<?= URL_CSS . $file ?>?v1">
<?php endforeach; ?>

<?php foreach ($css_bonus ?? [] as $file): ?>
    <link rel="stylesheet" href="<?= URL_CSS . $file ?>?v1">
<?php endforeach; ?>