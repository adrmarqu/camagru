<section>
    <h1><?= $formTitle ?></h1>
    <div class="error-container">
        <span id="error-global"><?= $globalErr ?></span>
    </div>
    <form id="form" action="<?= $pages['send'] ?>" method="POST">
        <input type="hidden" name="form_type" value="send">
        <div>
            <label for="email"><?= $email ?></label>
            <input type="email" name="email" id="email" autocomplete="email" readonly>
        </div>
        <div>
            <button type="submit"><?= $send ?></button>
        </div>
    </form>
</section>