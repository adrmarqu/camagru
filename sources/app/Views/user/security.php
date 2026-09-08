<!-- Seguridad -->
<section class="profile-card" id="card-security">
    <div class="card-header">
        <h3><?= Lang::t('profile.security.title') ?></h3>
        <button id="btn-edit-security" type="button" class="btn-secondary">
            <?= Lang::t('btn.edit') ?>
        </button>
    </div>
    
    <hr>
    
    <div class="error-container" role="alert" aria-live="polite">
        <span id="error-global-security" class="error-message"></span>
    </div>

    <!-- Modo normal -->
    <div id="security-view" class="info-display">
        <div class="info-group">
            <span class="info-label"><?= Lang::t('form.label.pass') ?></span>
            <span class="info-value">************************</span>
        </div>
    </div>
    
    <!-- Modo edición -->
    <form id="form-security" class="ajax-form hidden" action="/api/form.php" method="POST" novalidate>
        <input type="hidden" name="action" value="password">

        <!-- Contraseña actual -->
        <div class="form-group">
            <label for="password"><?= Lang::t('profile.security.curr') ?></label>
            <div class="password-wrapper">
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    placeholder="<?= Lang::t('form.ph.curr') ?>"
                    autocomplete="current-password" 
                    aria-describedby="error-password"
                    required
                >
                <button type="button" class="btn-toggle-pass" aria-label="Mostrar u ocultar contraseña">🙈</button>
            </div>
            <span id="error-password" class="field-error" aria-live="polite"></span>
        </div>

        <!-- Nueva contraseña -->
        <div class="form-group">
            <label for="new"><?= Lang::t('profile.security.new') ?></label>
            <div class="password-wrapper">
                <input 
                    type="password" 
                    name="new" 
                    id="new" 
                    autocomplete="new-password" 
                    placeholder="<?= Lang::t('form.ph.new') ?>"
                    aria-describedby="error-new"
                    required
                >
                <button type="button" class="btn-toggle-pass" aria-label="Mostrar u ocultar contraseña">🙈</button>
            </div>
            <span id="error-new" class="field-error" aria-live="polite"></span>
        </div>

        <!-- Confirmar nueva contraseña -->
        <div class="form-group">
            <label for="confirm"><?= Lang::t('profile.security.conf') ?></label>
            <div class="password-wrapper">
                <input 
                    type="password" 
                    name="confirm" 
                    id="confirm" 
                    autocomplete="new-password" 
                    placeholder="<?= Lang::t('form.ph.confi') ?>"
                    aria-describedby="error-confirm"
                    required
                >
                <button type="button" class="btn-toggle-pass" aria-label="Mostrar u ocultar contraseña">🙈</button>
            </div>
            <span id="error-confirm" class="field-error" aria-live="polite"></span>
        </div>

        <div class="form-actions">
            <button id="btn-cancel-security" type="reset" class="btn-cancel">
                <?= Lang::t('btn.cancel') ?>
            </button>
            <button type="submit" id="btn-submit-security" class="btn-primary">
                <span class="btn-text"><?= Lang::t('btn.update') ?></span>
                <span class="btn-spinner hidden">⏳</span>
            </button>
        </div>
    </form>
</section>