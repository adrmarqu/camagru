<?php
    /* Current page */
    $page = $_SESSION['page'] ?? 'gallery';
    $lang = Lang::getLang();

    /* URL of the pages */
    $galleryUrl = ViewHelper::url();
    $editorUrl = ViewHelper::url('photo-editor');
    $loginUrl = ViewHelper::url('login');
    $signinUrl = ViewHelper::url('signin');
    $profileUrl = ViewHelper::url('profile');
    $favUrl = ViewHelper::url('favorites');
    $privateUrl = ViewHelper::url('private-gallery');

    /* Header Label */
    $gallery = Lang::t('header.gallery');
    $editor = Lang::t('header.editor');
    $login = Lang::t('header.login');
    $signin = Lang::t('header.signin');
    $profile = Lang::t('header.profile');
    $fav = Lang::t('header.favorites');
    $private = Lang::t('header.private');

?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <?php require LAYOUT_TPL . '/head.php' ?>
</head>
<body>
    <header id="header">
        <?php require LAYOUT_TPL . '/header.php' ?>
    </header>
    
    <main>
        <?php require $this->file; ?>
    </main> 
    
    <footer id="footer">
        <?php require LAYOUT_TPL . '/footer.php' ?>
    </footer>
    
    <?php require PARTIAL_TPL . '/scripts.php' ?>
</body>
</html>