<section>
    <h1><?= $formTitle ?></h1>
    <div class="error-container">
        <span id="error-global"><?= $globalErr ?></span>
    </div>
    <form id="form" action="<?= $signinUrl ?>" method="POST">
        <input type="hidden" name="form_type" value="signin">
        <div>
            <label for="user"><?= $user ?></label>
            <input type="text" name="user" id="user" autocomplete="off" placeholder="<?= $userHold ?>" value="<?= ViewHelper::print($userVal)?>" class="<?= !empty($userErr) ? 'input-error' : '' ?>">
            <span id="error-user"><?= $userErr ?></span>
        </div>
        <div>
            <label for="email"><?= $email ?></label>
            <input type="email" name="email" id="email" autocomplete="email" placeholder="<?= $emailHold ?>" value="<?= ViewHelper::print($emailVal)?>" class="<?= !empty($emailErr) ? 'input-error' : '' ?>">
            <span id="error-email"><?= $emailErr ?></span>
        </div>
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
            <input type="checkbox" name="terms" id="terms" <?= $checked ?> class="<?= !empty($termsErr) ? 'input-error' : '' ?>">
            <label for="terms"><?= $terms ?></label>
            <span id="error-terms"><?= $termsErr ?></span>
        </div>
        <div>
            <button type="submit"><?= $send ?></button>
        </div>
    </form>
    <footer>
        <p><?= $yesAccount ?><a href="<?= $loginUrl ?>"><?= $account ?></a></p>
    </footer>
</section>