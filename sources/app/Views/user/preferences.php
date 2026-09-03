<!-- Preferencias -->
<section class="profile-card" id="card-preferences">
    <h3><?= Lang::t('profile.noti.title') ?></h3>
    <hr>
    <form id="form-preferences" class="ajax-form" action="/api/form.php" method="POST">
        <input type="hidden" name="action" value="preferences">
        <div class="form-group form-checkbox">
            <input type="checkbox" name="notifications" id="notifications" value="1" <?= $notiChecked ? 'checked' : '' ?>>
            <label for="notifications"><?= Lang::t('profile.noti.label') ?></label>
        </div>
        <span id="error-notifications" class="field-error" aria-live="polite"></span>
    </form>
</section>