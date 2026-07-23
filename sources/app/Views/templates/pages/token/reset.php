<section>
    <h1><?= $formTitle ?></h1>
    <div class="error-container">
        <span id="error-global"><?= $globalErr ?></span>
    </div>
    <form id="form" action="<?= $resetUrl ?>" method="POST">
        <input type="hidden" name="form_type" value="reset">
        <div>
            <label for="password"><?= $pass ?></label>
            <input type="password" name="password" id="password" autocomplete="new-password" placeholder="<?= $passHold ?>" class="<?= !empty($passErr) ? 'input-error' : '' ?>">
            <span id="error-password"><?= $passErr ?></span>
        </div>
        <div>
            <label for="confirm"><?= $confirm ?></label>
            <input type="password" name="confirm" id="confirm" autocomplete="new-password" placeholder="<?= $confHold ?>" class="<?= !empty($confirmErr) ? 'input-error' : '' ?>">
            <span id="error-confirm"><?= $confirmErr ?></span>
        </div>
        <div>
            <button type="submit"><?= $send ?></button>
        </div>
    </form>
</section>