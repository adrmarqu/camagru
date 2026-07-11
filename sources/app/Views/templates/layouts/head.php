<meta charset="UTF-8">
<title><?= $title ?? 'Camagru' ?></title>
<link rel="icon" href="/assets/logo.webp" type="image/webp">

<!-- Common Css -->
<!-- 
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    ...
-->

<?php foreach ($glob['css'] ?? [] as $file): ?>
    <link rel="stylesheet" href="<?= URL_CSS . $file ?>?v1">
<?php endforeach; ?>