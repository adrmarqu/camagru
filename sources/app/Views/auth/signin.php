<section class="form-container">
    <header class="form-header">
        <h1><?= Lang::t('signin.title') ?></h1>
        <p><?= Lang::t('signin.intro') ?></p>
    </header>

    <div class="error-container" role="alert" aria-live="polite">
        <span id="error-global" class="error-message"></span>
    </div>

    <form id="form" class="ajax-form" action="/api/form.php" method="POST" novalidate>

        <input type="hidden" name="action" value="signin">
        
        <!-- Usermail -->
        <div class="form-group">
            <label for="user"><?= Lang::t('form.label.user') ?></label>
            <input 
                type="text" 
                name="user" 
                id="user" 
                placeholder="<?= Lang::t('form.ph.user') ?>"
                aria-describedby="error-user"
            >
            <span id="error-user" class="field-error" aria-live="polite"></span>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email"><?= Lang::t('form.label.email') ?></label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                placeholder="<?= Lang::t('form.ph.email') ?>"
                aria-describedby="error-email"
            >
            <span id="error-email" class="field-error" aria-live="polite"></span>
        </div>

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

        <!-- Terms -->
        <div class="form-group form-checkbox">
            <input type="checkbox" name="terms" id="terms" value="1" aria-describedby="error-terms">
            <label for="terms"><?= Lang::t('signin.terms') ?></label>
            <span id="error-terms" class="field-error" aria-live="polite"></span>
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
            <?= Lang::t('signin.account') ?>
            <a href="<?= $loginUrl ?>"><?= Lang::t('signin.log') ?></a>
        </p>
    </footer>
</section>