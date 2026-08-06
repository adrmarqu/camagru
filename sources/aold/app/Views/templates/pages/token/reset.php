<section>
    <h1><?= $formTitle ?></h1>
    <div class="error-container">
        <span id="error-global"></span>
    </div>
    <form id="form" class="ajax-form" action="/<?= $lang ?>/api/reset" method="POST" data-redirect="<?= $loginUrl ?>">
        <input type="hidden" name="form_type" value="reset">
        <div>
            <label for="password"><?= $pass ?></label>
            <input type="password" name="password" id="password" autocomplete="new-password" placeholder="<?= $passHold ?>">
            <span id="error-password"></span>
        </div>
        <div>
            <label for="confirm"><?= $confirm ?></label>
            <input type="password" name="confirm" id="confirm" autocomplete="new-password" placeholder="<?= $confHold ?>">
            <span id="error-confirm"></span>
        </div>
        <div>
            <button type="submit"><?= $send ?></button>
        </div>
    </form>
</section>