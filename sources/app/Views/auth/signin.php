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
            <div class="checkbox-wrapper">
                <input type="checkbox" name="terms" id="terms" value="1" aria-describedby="error-terms">
                <label for="terms">
                    <?= Lang::t('signin.accept') !== 'signin.accept' ? Lang::t('signin.accept') : 'Acepto los' ?>
                    <button type="button" id="btn-open-terms" class="terms-link"><?= Lang::t('signin.terms') ?></button>
                </label>
            </div>
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

    <!-- Terms and Conditions Modal Dialog -->
    <dialog id="dialog-terms" class="terms-dialog">
        <div class="terms-modal-header">
            <h3><?= Lang::t('signin.terms') ?></h3>
            <button type="button" class="dialog-close-btn" id="dialog-close-terms" title="Cerrar" aria-label="Cerrar">&times;</button>
        </div>
        <div class="terms-modal-body">
            <h4>1. Uso del servicio</h4>
            <p>Camagru es una plataforma educativa de compartición de fotos y fotomontajes. El usuario es el único responsable de las imágenes y comentarios que publique.</p>
            
            <h4>2. Respeto y moderación</h4>
            <p>No se permite el contenido ofensivo, violento o que vulnere la privacidad de terceros. Las fotos o comentarios inapropiados podrán ser eliminados sin previo aviso.</p>
            
            <h4>3. Protección de datos</h4>
            <p>Tus datos (usuario y correo electrónico) se utilizan exclusivamente con fines de autenticación y notificaciones dentro de la aplicación. Puedes eliminar tu cuenta y todas tus fotos en cualquier momento desde tu perfil.</p>
        </div>
        <div class="terms-modal-footer">
            <button type="button" id="btn-accept-terms" class="btn-primary"><?= Lang::t('btn.accept') !== 'btn.accept' ? Lang::t('btn.accept') : 'Aceptar términos' ?></button>
        </div>
    </dialog>

    <!-- Links -->
    <footer class="form-footer">
        <p>
            <?= Lang::t('signin.account') ?>
            <a href="<?= $loginUrl ?>"><?= Lang::t('signin.log') ?></a>
        </p>
    </footer>
</section>