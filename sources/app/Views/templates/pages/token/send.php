<section>
    <h1><?= $sendTitle ?></h1>
    <div class="error-container">
        <span id="error-global"></span>
    </div>
    <p>
        <?= $sendBody ?>
    </p>
    <div class="show-container">
        <p><?php ViewHelper::print($email) ?></p>
    </div>
    <button id="btn-send"><?= $send ?></button>
</section>