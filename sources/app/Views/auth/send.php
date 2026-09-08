<section class="form-container">
    <header class="form-header">
        <h1><?= Lang::t('send.title') ?></h1>
        <p><?= Lang::t('send.intro') ?></p>
    </header>

    <div class="error-container" role="alert" aria-live="polite">
        <span id="error-global" class="error-message"></span>
    </div>

    <form id="form" class="ajax-form" action="/api/form.php" method="POST" novalidate>

        <input type="hidden" name="action" value="send">
        
        <!-- Email -->
        <div class="form-group">
            <label for="email"><?= Lang::t('form.label.email') ?></label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="<?= $_SESSION['send']['email'] ?? 'ERROR' ?>"
                readonly
                aria-describedby="error-email"
            >
            <span id="error-email" class="field-error" aria-live="polite"></span>
        </div>

        <!-- Button -->
        <div class="form-group">
            <button type="submit" id="btn-submit" class="btn-primary">
                <span class="btn-text"><?= Lang::t('btn.send') ?></span>
                <span class="btn-spinner hidden">⏳</span>
            </button>
        </div>
    </form>

    <!-- Links -->
    <footer class="form-footer">
        <p>
            <?= Lang::t('send.message') ?>
            <a href="<?= $galleryUrl ?>"><?= Lang::t('send.home') ?></a>
        </p>
    </footer>
</section>