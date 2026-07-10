<meta charset="UTF-8">
<title><?= $title ?? 'Camagru' ?></title>

<!-- Common Css -->
<!-- 
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/footer.css">
    ...
-->

<?php foreach ($css ?? [] as $file): ?>
    <link rel="stylesheet" href="<?= URL_CSS . $file ?>">
<?php endforeach; ?>