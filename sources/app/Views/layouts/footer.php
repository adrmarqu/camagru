<div class="footer-container">
    <!-- Top: Links Section -->
    <div class="footer-top">
        <!-- App Links -->
        <div class="footer-nav">
            <a href="<?= $galleryUrl ?>"><?= $gallery ?></a>
            <a href="<?= $editorUrl ?>"><?= $editor ?></a>
            <a href="<?= $profileUrl ?>"><?= $profile ?></a>
            <a href="<?= $favUrl ?>"><?= $fav ?></a>
            <a href="<?= $privateUrl ?>"><?= $private ?></a>
        </div>

        <!-- External Links -->
        <div class="footer-links">
            <a 
                href="https://adrmarqu.github.io" 
                target="_blank" 
                rel="noopener"
            >
                <?= Lang::t('footer.web') ?>
            </a>
            <span>•</span>
            <a 
                href="https://github.com/adrmarqu" 
                target="_blank" 
                rel="noopener"
            >
                GitHub
            </a>
            <span>•</span>
            <a 
                href="https://www.linkedin.com/in/adria-marquez/" 
                target="_blank" 
                rel="noopener"
            >
                LinkedIn
            </a>
        </div>
    </div>

    <!-- Bottom: Info & Credits Section -->
    <div class="footer-info">
        <p>
            &copy; <?= date('Y') ?> <strong>Camagru</strong>. <?= Lang::t('footer.rights') ?>
        </p>
        <p class="footer-credit">
            <?= Lang::t('footer.developed') ?><strong> 42Barcelona</strong>
        </p>
    </div>
</div>