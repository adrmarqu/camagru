<section class="form-container">
    <header class="form-header">
        <h1><?= Lang::t('reset.title') ?></h1>
        <p><?= Lang::t('reset.intro') ?></p>
    </header>

    <div class="error-container" role="alert" aria-live="polite">
        <span id="error-global" class="error-message"></span>
    </div>

    <form id="form" class="ajax-form" action="/api/form.php" method="POST" novalidate>

        <input type="hidden" name="action" value="reset">
        
        <!-- Password -->
        <div class="form-group">
            <label for="password"><?= Lang::t('form.label.pass') ?></label>
            <div class="password-wrapper">
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="<?= Lang::t('form.ph.pass') ?>"
                    aria-describedby="error-password"
                >
            </div>
            <span id="error-password" class="field-error" aria-live="polite"></span>
        </div>

        <!-- Confirm password -->
        <div class="form-group">
            <label for="confirm"><?= Lang::t('form.label.conf') ?></label>
            <div class="password-wrapper">
                <input 
                    type="password" 
                    name="confirm" 
                    id="confirm" 
                    placeholder="<?= Lang::t('form.ph.conf') ?>"
                    aria-describedby="error-confirm"
                >
            </div>
            <span id="error-confirm" class="field-error" aria-live="polite"></span>
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
            <?= Lang::t('reset.message') ?>
            <a href="<?= $loginUrl ?>"><?= Lang::t('reset.login') ?></a>
        </p>
    </footer>
</section>