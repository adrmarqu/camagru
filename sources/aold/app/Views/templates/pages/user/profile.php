<header class="profile-header">
    <h1><?= $titlePage ?></h1>
    <hr>
</header>

<div class="profile-grid">
    <!-- Avatar + stats -->
    <div class="profile-card avatar-stats-card">
        <form id="form-avatar" class="ajax-form flex col v-center" action="/api/profile/avatar.php" method="POST" enctype="multipart/form-data">
            <div class="profile-avatar-wrap">
                <img id="big-avatar" class="profile-avatar" src="<?= $avatarUrl ?>" alt="Avatar" title="Avatar">
                <div class="profile-avatar-overlay" id="btn-avatar-overlay" title="<?= $avatarBtn ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </div>
            </div>
            <button type="button" id="btn-avatar" class="btn-secondary"><?= $avatarBtn ?></button>
            <input id="input-avatar" class="hidden" type="file" name="avatar" accept="image/jpeg, image/png, image/webp, image/avif, image/heic">
            <span id="error-avatar" class="error-text"></span>
            <span id="error-global" class="error-text"></span>
        </form>

        <section class="stats-section">
            <h3><?= $stats ?></h3>
            <hr>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label"><?= $photosLabel ?></span>
                    <span class="stat-value" id="stat-photos"><?= $nPhotos ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?= $likesLabel ?></span>
                    <span class="stat-value" id="stat-likes"><?= $nLikes ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?= $commentsLabel ?></span>
                    <span class="stat-value" id="stat-comments"><?= $nComments ?></span>
                </div>
            </div>
        </section>
    </div>

    <!-- Information + Security -->
    <div class="profile-details-column">
        <!-- Info -->
        <section class="profile-card">
            <div class="flex row h-between v-center card-header">
                <h3><?= $info ?></h3>
                <button id="btn-info" type="button" class="btn-secondary"><?= $edit ?></button>
            </div>
            
            <hr>
            
            <!-- Display Information -->
            <div id="information" class="info-display">
                <p>
                    <span class="info-label"><?= $userText ?></span>
                    <strong id="user-val" class="info-value"><?= ViewHelper::print($username) ?></strong>
                </p>
                <p>
                    <span class="info-label"><?= $emailText ?></span>
                    <strong id="email-val" class="info-value"><?= ViewHelper::print($email) ?></strong>
                </p>
            </div>
            
            <!-- Edit Information Form -->
            <form id="form-info" class="ajax-form hidden" action="/api/profile/user.php" method="POST">
                <div class="form-container">
                    <span id="error-global" class="error-text"></span>
                    <span id="global-info" class="success-text"></span>
                </div>
                <div class="form-group">
                    <label for="user"><?= $userLabel ?></label>
                    <input id="user" type="text" name="user" value="<?= ViewHelper::print($username) ?>" required>
                    <span id="error-user" class="error-text"></span>
                </div>
                <div class="form-group">
                    <label for="email"><?= $emailLabel ?></label>
                    <input id="email" type="email" name="email" value="<?= ViewHelper::print($email) ?>" required>
                    <span id="error-email" class="error-text"></span>
                </div>
                <div class="form-actions">
                    <button name="cancel" type="button" class="btn-cancel"><?= $cancel ?></button>
                    <button name="save" type="submit" class="btn-primary"><?= $save ?></button>
                </div>
            </form>
        </section>
        
        <!-- Security -->
        <section class="profile-card">
            <div class="flex row h-between v-center card-header">
                <h3><?= $security ?></h3>
                <button id="btn-pass" type="button" class="btn-secondary"><?= $edit ?></button>
            </div>
            
            <hr>
            
            <!-- Security Display -->
            <div id="security" class="info-display">
                <p>
                    <span class="info-label"><?= $passText ?></span>
                    <span class="info-value">••••••••••••</span>
                </p>
            </div>
            
            <!-- Edit Password Form -->
            <form id="form-pass" class="ajax-form hidden" action="/api/profile/password.php" method="POST">
                <div class="form-container">
                    <span id="error-global" class="error-text"></span>
                    <span id="global-sec" class="success-text"></span>
                </div>
                <div class="form-group">
                    <label for="password"><?= $passLabel ?></label>
                    <input id="password" type="password" name="password" placeholder="<?= $passHold ?>" required>
                    <span id="error-password" class="error-text"></span>
                    <span id="error-pass" class="error-text"></span>
                </div>
                <div class="form-group">
                    <label for="new_pass"><?= $newLabel ?></label>
                    <input id="new_pass" type="password" name="new_pass" placeholder="<?= $newHold ?>" required>
                    <span id="error-new_pass" class="error-text"></span>
                    <span id="error-new" class="error-text"></span>
                </div>
                <div class="form-group">
                    <label for="confirm"><?= $confLabel ?></label>
                    <input id="confirm" type="password" name="confirm" placeholder="<?= $confHold ?>" required>
                    <span id="error-confirm" class="error-text"></span>
                </div>
                <div class="form-actions">
                    <button name="cancel" type="button" class="btn-cancel"><?= $cancel ?></button>
                    <button name="save" type="submit" class="btn-primary"><?= $save ?></button>
                </div>
            </form>
        </section>
    </div>
</div>

<div class="profile-grid bottom-grid">
    <!-- Notification Preferences -->
    <section class="profile-card">
        <h3><?= $notification ?></h3>
        <hr>
        <form id="form-noti" class="ajax-form flex row v-center gap-10" action="/api/profile/noti.php" method="POST">
            <input id="noti" type="checkbox" name="notification" <?= $checked ?>>
            <label for="noti"><?= $notiLabel ?></label>
            <div id="loader" class="spinner hidden"></div>
            <span id="error-noti" class="error-text"></span>
            <span id="error-notification" class="error-text"></span>
            <span id="global-noti" class="success-text"></span>
        </form>
    </section>
    
    <!-- Danger Zone -->
    <section class="profile-card danger-card">
        <h3><?= $deleteTitle ?></h3>
        <hr>
        <p><?= $deleteText ?></p>
        <button id="btn-del" type="button" class="btn-danger"><?= $deleteBtn ?></button>
    </section>
</div>

<!-- Account Deletion Dialog -->
<dialog id="dialog-del" class="modal-dialog">
    <form id="form-del" class="ajax-form modal-content" action="/api/profile/delete.php" method="POST">
        <h3><?= $sure ?></h3>
        <p><?= $confirmDel ?></p>
        <div class="form-container">
            <span id="error-global" class="error-text"></span>
            <span id="global-danger" class="error-text"></span>
        </div>
        <div class="form-group">
            <label for="del-password"><?= $passLabel ?></label>
            <input id="del-password" type="password" name="password" placeholder="<?= $passHold ?>" required>
            <span id="error-password" class="error-text"></span>
            <span id="error-del" class="error-text"></span>
        </div>
        <div class="form-actions">
            <button type="button" name="cancel" id="btn-del-cancel" class="btn-cancel"><?= $cancel ?></button>
            <button type="submit" name="save" class="btn-danger"><?= $save ?></button>
        </div>
    </form>
</dialog>