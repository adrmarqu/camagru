<section>
    <h1><?= $formTitle ?></h1>
    <div class="error-container">
        <span id="error-global"></span>
    </div>
    <form id="form" action="<?= $pages['forgot'] ?>" method="POST">
        <input type="hidden" name="form_type" value="forgot">
        <div>
            <label for="usermail"><?= $usermail ?></label>
            <input type="text" name="usermail" id="usermail" autocomplete="username" placeholder="<?= $userHold ?>">
            <span id="error-usermail"><?= $usermailErr ?></span>
        </div>
        <div>
            <button type="submit"><?= $send ?></button>
        </div>
    </form>
</section>