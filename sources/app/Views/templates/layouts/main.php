<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head><?php require LAYOUT_PATH . '/head.php' ?></head>
<body>
    <header id="header"><?php require LAYOUT_PATH . '/header.php' ?></header>
    <main><?= $content ?></main>
    <footer><?php require LAYOUT_PATH . '/footer.php' ?></footer>
    <?php require LAYOUT_PATH . '/scripts.php' ?>
</body>
</html>