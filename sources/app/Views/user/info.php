<!-- Información -->
<section class="profile-card" id="card-info">
    <div class="card-header">
        <h3><?= Lang::t('profile.info.title') ?></h3>
        <button id="btn-edit-info" type="button" class="btn-secondary">
            <?= Lang::t('btn.edit') ?>
        </button>
    </div>
    
    <hr>
    
    <!-- Modo normal -->
    <div id="info-view" class="info-display">
        <div class="info-group">
            <span class="info-label"><?= Lang::t('profile.info.user') ?></span>
            <strong id="user-val" class="info-value"><?= ViewHelper::print($_SESSION['user']['name'] ?? '') ?></strong>
        </div>
        <div class="info-group">
            <span class="info-label"><?= Lang::t('form.label.email') ?></span>
            <strong id="email-val" class="info-value"><?= ViewHelper::print($_SESSION['user']['email'] ?? '') ?></strong>
        </div>
    </div>
    
    <!-- Modo edición -->
    <form id="form-info" class="ajax-form hidden" action="/api/form.php" method="POST" novalidate>
        <input type="hidden" name="action" value="user">

        <div class="error-container" role="alert" aria-live="polite">
            <span id="error-global" class="error-message"></span>
        </div>

        <div class="form-group">
            <label for="user"><?= Lang::t('profile.info.user') ?></label>
            <input 
                type="text" 
                name="user" 
                id="user" 
                value="<?= ViewHelper::print($_SESSION['user']['name'] ?? 'guest') ?>" 
                autocomplete="username" 
                placeholder="<?= Lang::t('form.ph.user') ?>"
                aria-describedby="error-user"
                required
            >
            <span id="error-user" class="field-error" aria-live="polite"></span>
        </div>

        <div class="form-group">
            <label for="email"><?= Lang::t('form.label.email') ?></label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="<?= ViewHelper::print($_SESSION['user']['email'] ?? 'user@user.com') ?>" 
                autocomplete="email" 
                placeholder="<?= Lang::t('form.ph.email') ?>"
                aria-describedby="error-email"
                required
            >
            <span id="error-email" class="field-error" aria-live="polite"></span>
        </div>

        <div class="form-actions">
            <button id="btn-cancel-info" type="button" class="btn-cancel">
                <?= Lang::t('btn.cancel') ?>
            </button>
            <button type="submit" id="btn-submit-info" class="btn-primary">
                <span class="btn-text"><?= Lang::t('btn.update') ?></span>
                <span class="btn-spinner hidden">⏳</span>
            </button>
        </div>
    </form>
</section>