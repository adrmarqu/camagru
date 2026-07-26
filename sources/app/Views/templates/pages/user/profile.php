<header>
    <h1><?= $titlePage ?></h1>
    <hr>
</header>
<div class="flex row">
    <!-- Avatar + stats -->
    <div class="profile-card">
        <div class="flex col v-center">
            <img id="big-avatar" src="<?= $avatarUrl ?>" alt="Avatar img" title="Avatar img">
            <button id="btn-avatar"><?= $avatarBtn ?></button>
            <input id="input-avatar" class="hidden" type="file" name="avatar" accept="image/jpeg, image/png, image/webp, image/avif, image/heic">
            <span id="error-avatar"></span>
        </div>
        <section>
            <h3><?= $stats ?></h3><hr>
            <div>
                <p><?= $photosLabel ?><?= $nPhotos ?></p>
                <p><?= $likesLabel ?><?= $nLikes ?></p>
                <p><?= $commentsLabel ?><?= $nComments ?></p>
            </div>
        </section>
    </div>
    <!-- Information + Security -->
    <div>
        <!-- Info -->
        <section class="profile-card">
            <div class="flex row">
                <h3><?= $info ?></h3>
                <button id="btn-info"><?= $edit ?></button>
            </div>
            
            <hr>
            
            <!-- Information -->
            <div id="information">
                <p>
                    <span><?= $userText ?></span>
                    <?= ViewHelper::print($username) ?>
                </p>
                <p>
                    <span><?= $emailText ?></span>
                    <?= ViewHelper::print($email) ?>
                </p>
            </div>
            
            <!-- Edit information -->
            <form id="form-info" class="hidden">
                <div class="form-container">
                    <span id="global-info"></span>
                </div>
                <div>
                    <label for="user"><?= $userLabel ?></label>
                    <input type="text" name="user" value="<?= ViewHelper::print($username) ?>">
                    <span id="error-user"></span>
                </div>
                <div>
                    <label for="email"><?= $emailLabel ?></label>
                    <input type="email" name="email" value="<?= ViewHelper::print($email) ?>">
                    <span id="error-email"></span>
                </div>
                <div>
                    <button name="cancel" type="button"><?= $cancel ?></button>
                    <button name="save" type="submit"><?= $save ?></button>
                </div>
            </form>
        </section>
        
        <!-- Security -->
        <section class="profile-card">
            <div class="flex row">
                <h3><?= $security ?></h3>
                <button id="btn-pass"><?= $edit ?></button>
            </div>
            
            <hr>
            
            <!-- Password -->
            <div id="security">
                <p>
                    <span><?= $passText ?></span>
                    **********
                </p>
            </div>
            
            <!-- Edit password -->
            <form id="form-pass" class="hidden">
                <div class="form-container">
                    <span id="global-sec"></span>
                </div>
                <div>
                    <label for="password"><?= $passLabel ?></label>
                    <input type="password" name="password" placeholder="<?= $passHold ?>">
                    <span id="error-pass"></span>
                </div>
                <div>
                    <label for="new_pass"><?= $newLabel ?></label>
                    <input type="password" name="new_pass" placeholder="<?= $newHold ?>">
                    <span id="error-new"></span>
                </div>
                <div>
                    <label for="confirm"><?= $confLabel ?></label>
                    <input type="password" name="confirm" placeholder="<?= $confHold ?>">
                    <span id="error-confirm"></span>
                </div>
                <div>
                    <button name="cancel" type="reset"><?= $cancel ?></button>
                    <button name="save" type="submit"><?= $save ?></button>
                </div>
            </form>
        </section>
    </div>
</div>
<div class="flex row">
    <!-- Noti -->
    <section class="profile-card">
        <h3><?= $notification ?></h3><hr>
        <form id="form-noti">
            <input id="noti" type="checkbox" name="notification" <?= $checked ?>>
            <label for="notification"><?= $notiLabel ?></label>
            <div id="loader" class="spinner hidden"></div>
            <span id="error-noti"></span>
        </form>
    </section>
    
    <!-- Danger -->
    <section class="profile-card">
        <h3><?= $deleteTitle ?></h3><hr>
        <p><?= $deleteText ?></p>
        <button id="btn-del"><?= $deleteBtn ?></button>
    </section>
    <dialog id="dialog-del">
        <form id="form-del">
            <h3><?= $sure ?></h3>
            <p><?= $confirmDel ?></p>
            <div class="form-container">
                <span id="global-danger"></span>
            </div>
            <div>
                <label for="password"><?= $passLabel ?></label>
                <input type="password" name="password" placeholder="<?= $passHold ?>">
                <span id="error-del"></span>
            </div>
            <div>
                <button type="reset" name="cancel"><?= $cancel ?></button>
                <button type="submit" name="save"><?= $save ?></button>
            </div>
        </form>
    </dialog>
</div>