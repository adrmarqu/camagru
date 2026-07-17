<section>
    <h1><?= $formTitle ?></h1>
    <div class="error-container">
        <span id="error-global"><?= $globalErr ?></span>
    </div>
    <form id="form" action="<?= $pages['signin'] ?>" method="POST">
        <input type="hidden" name="form_type" value="signin">
        <div>
            <label for="user"><?= $user ?></label>
            <input type="text" name="user" id="user" autocomplete="username" placeholder="<?= $userHold ?>">
            <span id="error-user"><?= $userErr ?></span>
        </div>
        <div>
            <label for="email"><?= $email ?></label>
            <input type="email" name="email" id="email" autocomplete="email" placeholder="<?= $emailHold ?>">
            <span id="error-email"><?= $emailErr ?></span>
        </div>
        <div>
            <label for="password"><?= $pass ?></label>
            <input type="password" name="password" id="password" autocomplete="new-password" placeholder="<?= $passHold ?>">
            <span id="error-password"><?= $passErr ?></span>
        </div>
        <div>
            <label for="confirm"><?= $confirm ?></label>
            <input type="password" name="confirm" id="confirm" autocomplete="new-password" placeholder="<?= $confHold ?>">
            <span id="error-confirm"><?= $confirmErr ?></span>
        </div>
        <div>
            <input type="checkbox" name="terms" id="terms">
            <label for="terms"><?= $terms ?></label>
            <span id="error-terms"><?= $termsErr ?></span>
        </div>
        <div>
            <button type="submit"><?= $send ?></button>
        </div>
    </form>
</section>