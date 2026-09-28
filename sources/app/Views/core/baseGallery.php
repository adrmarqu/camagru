<?php

$ph = Lang::t('form.ph.comment');
$isLoggedIn = isset($_SESSION['user']['id']);
$loginUrl = ViewHelper::url('login');

?>

<div id="gallery-container">

    <div class="gallery-header">
        <h1><?= ViewHelper::print($h1 ?? 'Galería') ?></h1>
        <hr>
    </div>

    <div id="gallery-grid" class="gallery-grid" data-logged-in="<?= $isLoggedIn ? '1' : '0' ?>" data-login-url="<?= $loginUrl ?>" data-gallery-type="<?= htmlspecialchars($galleryType ?? 'gallery') ?>">
        <?php foreach ($photoData as $info): ?>
            <article class="gallery-card card" data-photo-id="<?= $info['id'] ?>">
                
                <!-- Card Header: User Info -->
                <header class="gallery-card-header">
                    <div class="user-info">
                        <div class="user-avatar-placeholder">
                            <?= strtoupper(substr($info['username'] ?? 'U', 0, 1)) ?>
                        </div>
                        <span class="user-name"><?= ViewHelper::print($info['username']) ?></span>
                    </div>
                    <div class="header-meta">
                        <?php if (!empty($info['created_at'])): ?>
                            <time class="post-date" datetime="<?= $info['created_at'] ?>">
                                <?= date('d M Y', strtotime($info['created_at'])) ?>
                            </time>
                        <?php endif; ?>
                        <?php if (($galleryType ?? '') === 'private'): ?>
                            <button type="button" class="btn-del-photo" data-src="<?= htmlspecialchars($info['src']) ?>" title="Eliminar foto" aria-label="Eliminar foto">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                </svg>
                            </button>
                        <?php endif; ?>
                    </div>
                </header>

                <!-- Photo Container with Double Tap Heart Animation -->
                <div class="gallery-image-wrapper">
                    <img src="<?= $info['src'] ?>" alt="Foto de <?= ViewHelper::print($info['username']) ?>" loading="lazy" class="gallery-img">
                    <div class="heart-pulse-overlay" aria-hidden="true">❤️</div>
                </div>

                <!-- Action Buttons: Likes and Comments -->
                <div class="gallery-card-actions">
                    <button type="button" class="action-btn btn-like <?= !empty($info['user_liked']) ? 'liked' : '' ?>" aria-label="Me gusta">
                        <span class="heart-icon"><?= !empty($info['user_liked']) ? '❤️' : '🤍' ?></span>
                        <span class="like-count"><?= (int)$info['n_likes'] ?></span>
                    </button>

                    <button type="button" class="action-btn btn-comment" aria-label="Comentarios">
                        <span class="comment-icon">💬</span>
                        <span class="comment-count"><?= (int)$info['n_comments'] ?></span>
                    </button>
                </div>

                <!-- Comments Section (Drawer) -->
                <div class="gallery-comments-section">
                    <div class="comments-list">
                        <?php if (empty($info['comments'])): ?>
                            <p class="no-comments-msg"><?= Lang::t('gallery.no_comment') ?></p>
                        <?php else: ?>
                            <?php foreach ($info['comments'] as $c): ?>
                                <div class="comment-item" data-comment-id="<?= $c['id'] ?>">
                                    <div class="comment-content">
                                        <strong class="comment-user"><?= ViewHelper::print($c['user']) ?></strong>
                                        <span class="comment-text"><?= ViewHelper::print($c['text']) ?></span>
                                    </div>
                                    <?php if (!empty($c['can_delete'])): ?>
                                        <button type="button" class="btn-del-comment" title="Eliminar comentario" aria-label="Eliminar">&times;</button>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($isLoggedIn): ?>
                        <form class="comment-form" autocomplete="off">
                            <input type="text" name="comment" class="comment-input" placeholder="<?= htmlspecialchars($ph) ?>" maxlength="255" required>
                            <button type="submit" class="btn-send-comment" title="<?= Lang::t('btn.send') ?>">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="gallery-login-prompt">
                            <a href="<?= $loginUrl ?>"><?= Lang::t('header.login') ?></a> <?= Lang::t('gallery.do') ?>
                        </div>
                    <?php endif; ?>
                </div>

            </article>
        <?php endforeach; ?>
    </div>

    <!-- Empty Gallery State -->
    <div id="gallery-empty" class="gallery-empty-card <?= empty($photoData) ? '' : 'hidden' ?>">
        <div class="empty-icon" aria-hidden="true">📷</div>
        <p class="empty-title"><?= Lang::t('gallery.empty') ?></p>
        <?php if ($isLoggedIn): ?>
            <a href="<?= ViewHelper::url('photo-editor') ?>" class="btn-empty-action">
                <?= Lang::t('header.editor') ?>
            </a>
        <?php else: ?>
            <a href="<?= $loginUrl ?>" class="btn-empty-action">
                <?= Lang::t('header.login') ?>
            </a>
        <?php endif; ?>
    </div>

    <!-- Load More Pagination -->
    <div class="gallery-pagination <?= count($photoData) < 6 ? 'hidden' : '' ?>">
        <button id="btn-load-more" class="btn-secondary" type="button">
            <span class="btn-text"><?= Lang::t('btn.more') ?></span>
            <span class="spinner hidden" aria-hidden="true"></span>
        </button>
    </div>

    <div id="gallery-end-msg" class="gallery-msg hidden">
        <p><?= Lang::t('gallery.load') ?></p>
    </div>

    <!-- Confirmation Dialog for Photo Deletion (Private Gallery) -->
    <?php if (($galleryType ?? '') === 'private'): ?>
    <dialog id="dialog-del-photo" class="gallery-dialog">
        <div class="dialog-header">
            <h3>¿Eliminar foto?</h3>
        </div>
        <p class="dialog-desc"><?= Lang::t('gallery.sure') ?></p>
        <div class="dialog-preview-container">
            <img id="dialog-del-img" src="" alt="Vista previa de foto" class="dialog-del-preview">
        </div>
        <div class="dialog-actions">
            <button type="button" id="btn-cancel-del-photo" class="btn-cancel"><?= Lang::t('btn.cancel') ?></button>
            <button type="button" id="btn-confirm-del-photo" class="btn-danger"><?= Lang::t('btn.thumbnail') ?></button>
        </div>
    </dialog>
    <?php endif; ?>

</div>