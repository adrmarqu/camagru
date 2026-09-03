<!-- Zona de peligro -->
<section class="profile-card danger-card" id="card-danger">
    <h3><?= Lang::t('profile.danger.title') ?></h3>
    <hr>
    <div class="danger-action">
        <label for="btn-del" class="danger-label">
            <?= Lang::t('profile.danger.delete') ?>
        </label>
        <button id="btn-del" type="button" class="btn-danger">
            <?= Lang::t('btn.delete') ?>
        </button>
    </div>
</section>

<!-- Modal de confirmación para eliminar cuenta -->
<dialog id="dialog-del">
    <form id="form-del" class="ajax-form" action="/api/form.php" method="POST" novalidate>
        <input type="hidden" name="action" value="delete">

        <h3><?= Lang::t('profile.danger.sure') ?></h3>
        <p><?= Lang::t('profile.danger.confirm') ?></p>

        <div class="error-container" role="alert" aria-live="polite">
            <span id="error-global" class="error-message"></span>
        </div>

        <div class="form-group">
            <label for="del-password"><?= Lang::t('profile.danger.pass') ?></label>
            <div class="password-wrapper">
                <input 
                    type="password" 
                    name="password" 
                    id="del-password" 
                    placeholder="Tu contraseña actual" 
                    aria-describedby="error-password"
                    required
                >
                <button type="button" class="btn-toggle-pass" aria-label="Mostrar u ocultar contraseña">🙈</button>
            </div>
            <span id="error-password" class="field-error" aria-live="polite"></span>
        </div>

        <div class="form-actions">
            <button id="btn-cancel-del" type="button" class="btn-secondary">
                Cancelar
            </button>
            <button id="btn-submit-del" type="submit" class="btn-danger">
                <span class="btn-text"><?= Lang::t('btn.delete') ?></span>
                <span class="btn-spinner hidden">⏳</span>
            </button>
        </div>
    </form>
</dialog>