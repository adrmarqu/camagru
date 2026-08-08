<?php

$page = $_SESSION['page'] ?? 'gallery';
$pageTitle = 'Camagru | ' . Lang::t("title.$page");

?>

<meta charset="UTF-8">
<title><?= $pageTitle ?></title>

<link rel="icon" href="/assets/logo.webp" type="image/webp">

<?php require PARTIAL_TPL . '/styles.php'; ?>