<!DOCTYPE html>
<html lang="<?= Lang::getLang() ?>">
<head><?php require LAYOUT_PATH . '/head.php' ?></head>
<body>
    <header><?php require LAYOUT_PATH . '/header.php' ?></header>
    <main><?php require $screen ?></main>
    <footer><?php require LAYOUT_PATH . '/footer.php' ?></footer>
    <?php require LAYOUT_PATH . '/scripts.php' ?>
</body>
</html>