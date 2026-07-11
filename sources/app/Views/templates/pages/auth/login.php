<section>
    <h1><?= $formTitle ?></h1>
    <form action="/api/checkForm.php" method="POST">
        <div>
            <label for="usermail"><?= $usermail ?></label>
            <input type="text" name="usermail">
            <span><?= $usermailErr ?></span>
        </div>
        <div>
            <label for="password"><?= $pass ?></label>
            <input type="password" name="password">
            <span><?= $passErr ?></span>
        </div>
        <div>
            <input type="checkbox" name="remember_me">
            <label for="remember_me"><?= $remember ?></label>
        </div>
    </form>
    <div>
        <p><?= $noAccount ?><a href="/<?= $lang ?>/signin"><?= $account ?></a></p>
    </div>
</section>
