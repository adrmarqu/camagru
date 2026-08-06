<section>
    <h1><?= $formTitle ?></h1>
    <div class="error-container">
        <span id="error-global"></span>
    </div>
    <form id="form" class="ajax-form" action="/<?= $lang ?>/api/login" method="POST" data-redirect="<?= $galleryUrl ?>">
        <input type="hidden" name="form_type" value="login">
        <div>
            <label for="usermail"><?= $usermail ?></label>
            <input type="text" name="usermail" id="usermail" autocomplete="username" placeholder="<?= $userHold ?>">
            <span id="error-usermail"></span>
        </div>
        <div>
            <label for="password"><?= $pass ?></label>
            <input type="password" name="password" id="password" autocomplete="current-password" placeholder="<?= $passHold ?>">
            <span id="error-password"></span>
        </div>
        <div>
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me"><?= $remember ?></label>
        </div>
        <div>
            <button type="submit"><?= $send ?></button>
        </div>
    </form>
    <footer>
        <p><?= $noAccount ?><a href="<?= $signinUrl ?>"><?= $account ?></a></p>
        <p><?= $forgot ?><a href="<?= $forgotUrl ?>"><?= $reset ?></a></p>
    </footer>
</section>
