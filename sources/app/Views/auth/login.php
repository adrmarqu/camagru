<section class="form-container">
    <header class="form-header">
        <h1><?= Lang::t('login.title') ?></h1>
        <p><?= Lang::t('login.intro') ?></p>
    </header>

    <div class="error-container" role="alert" aria-live="polite">
        <span id="error-global" class="error-message"></span>
    </div>

    <form id="form" class="ajax-form" action="/api/form.php" method="POST" novalidate>

        <input type="hidden" name="action" value="login">
        
        <!-- Usermail -->
        <div class="form-group">
            <label for="usermail"><?= Lang::t('form.label.usermail') ?></label>
            <input 
                type="text" 
                name="usermail" 
                id="usermail" 
                autocomplete="username" 
                placeholder="<?= Lang::t('form.ph.usermail') ?>"
                aria-describedby="error-usermail"
            >
            <span id="error-usermail" class="field-error" aria-live="polite"></span>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password"><?= Lang::t('form.label.pass') ?></label>
            <div class="password-wrapper">
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    autocomplete="current-password" 
                    placeholder="<?= Lang::t('form.ph.pass') ?>"
                    aria-describedby="error-password"
                >
                <button type="button" id="toggle-password" class="btn-toggle-pass" aria-label="Show or hide the pass">
                    🙈
                </button>
            </div>
            <span id="error-password" class="field-error" aria-live="polite"></span>
        </div>

        <!-- Remember me -->
        <div class="form-group form-checkbox">
            <input type="checkbox" name="remember_me" id="remember_me" value="1">
            <label for="remember_me"><?= Lang::t('login.remember') ?></label>
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
            <?= Lang::t('login.no_account') ?>
            <a href="<?= $signinUrl ?>"><?= Lang::t('login.new') ?></a>
        </p>
        <p>
            <?= Lang::t('login.forgot') ?>
            <a href="<?= $forgotUrl ?>"><?= Lang::t('login.reset') ?></a>
        </p>
    </footer>
</section>