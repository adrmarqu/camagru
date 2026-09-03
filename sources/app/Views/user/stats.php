<?php

$folder = $_SESSION['user']['folder'] ?? null;
$avatarUrl = "/uploads/$folder/avatar/avatar.webp";
if (!file_exists($avatarUrl)) $avatarUrl = '/assets/default.webp';

?>

<section class="profile-card profile-avatar-stats" id="card-avatar-stats">

    <!-- Avatar -->
    <div class="avatar-section">
        <div class="avatar-wrapper">
            <img id="avatar-preview" src="<?= $avatarUrl ?>" alt="Avatar" title="avatar">

            <form id="form-avatar" class="avatar-form" action="/api/form.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="action" value="avatar">
                <label for="avatar-input" class="btn-avatar-change" title="Cambiar foto de perfil">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <span><?= Lang::t('profile.stats.change_photo') ?></span>
                </label>
                <input id="avatar-input" type="file" name="avatar" accept="image/*" class="avatar-file-input">

            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-section">
        
        <h3><?= Lang::t('profile.stats.title') ?></h3>
        <hr>
        
        <div class="stats-grid">
            
            <div class="stat-item">
                <span class="stat-label">
                    <?= Lang::t('profile.stats.photos') ?>
                </span>
                <span class="stat-value" id="stat-photos"><?= $nPhotos ?></span>
            </div>
            
            <div class="stat-item">
                <span class="stat-label">
                    <?= Lang::t('profile.stats.likes') ?>
                </span>
                <span class="stat-value" id="stat-likes"><?= $nLikes ?></span>
            </div>
            
            <div class="stat-item">
                <span class="stat-label">
                    <?= Lang::t('profile.stats.comments') ?>
                </span>
                <span class="stat-value" id="stat-comments"><?= $nComments ?></span>
            </div>
        
        </div>
    </div>
</section>