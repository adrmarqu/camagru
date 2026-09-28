/**
 * CAMAGRU - GALLERY INTERACTION SCRIPT
 * Handles Likes, Double-tap to Like, Comments, Comment Deletion, 
 * Photo Deletion (Private Gallery), and Infinite / Load More Pagination.
 */

document.addEventListener("DOMContentLoaded", () => {
    const galleryGrid = document.getElementById("gallery-grid");
    if (!galleryGrid) return;

    const isLoggedIn = galleryGrid.dataset.loggedIn === "1";
    const loginUrl = galleryGrid.dataset.loginUrl || "/en/login";
    const galleryType = galleryGrid.dataset.galleryType || "gallery";
    const btnLoadMore = document.getElementById("btn-load-more");
    const paginationContainer = document.querySelector(".gallery-pagination");
    const endMsg = document.getElementById("gallery-end-msg");
    const emptyMsg = document.getElementById("gallery-empty");

    // Dialog elements for photo deletion (private gallery)
    const dialogDelPhoto = document.getElementById("dialog-del-photo");
    const dialogDelImg = document.getElementById("dialog-del-img");
    const btnCancelDelPhoto = document.getElementById("btn-cancel-del-photo");
    const btnConfirmDelPhoto = document.getElementById("btn-confirm-del-photo");

    let photoPendingDelete = null; // { card: Element, src: string }

    // Track current offset based on initial rendered cards
    let currentOffset = galleryGrid.querySelectorAll(".gallery-card").length;

    /* ==========================================================================
       1. HELPER: ESCAPE HTML
       ========================================================================== */
    const escapeHtml = (str) => {
        if (!str) return "";
        const div = document.createElement("div");
        div.textContent = str;
        return div.innerHTML;
    };

    /* ==========================================================================
       2. LIKE TOGGLE HANDLER
       ========================================================================== */
    const toggleLike = async (photoId, btnLike, heartOverlay = null) => {
        if (!isLoggedIn) {
            window.location.href = loginUrl;
            return;
        }

        if (btnLike) btnLike.disabled = true;

        try {
            const response = await fetch("/api/like.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({ photo_id: parseInt(photoId, 10) })
            });

            const data = await response.json();

            if (data.success && btnLike) {
                btnLike.classList.toggle("liked", data.liked);
                const heartIcon = btnLike.querySelector(".heart-icon");
                const countSpan = btnLike.querySelector(".like-count");

                if (heartIcon) heartIcon.textContent = data.liked ? "❤️" : "🤍";
                if (countSpan) countSpan.textContent = data.n_likes;

                if (heartOverlay && data.liked) {
                    heartOverlay.classList.remove("animate");
                    void heartOverlay.offsetWidth; // Force DOM reflow
                    heartOverlay.classList.add("animate");
                }
            }
        } catch (err) {
            console.error("Error toggling like:", err);
        } finally {
            if (btnLike) btnLike.disabled = false;
        }
    };

    /* ==========================================================================
       3. DELETE COMMENT HANDLER
       ========================================================================== */
    const deleteComment = async (commentId, itemElement, cardElement) => {
        if (!isLoggedIn || !commentId || !itemElement) return;

        try {
            const response = await fetch("/api/delete_comment.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({ comment_id: parseInt(commentId, 10) })
            });

            const data = await response.json();

            if (data.success) {
                itemElement.classList.add("fade-out");
                setTimeout(() => {
                    const list = itemElement.closest(".comments-list");
                    itemElement.remove();

                    // If no comments left, display empty message
                    if (list && list.querySelectorAll(".comment-item").length === 0) {
                        list.innerHTML = '<p class="no-comments-msg">Aún no hay comentarios. ¡Sé el primero!</p>';
                    }

                    // Update comment counter in card actions
                    if (cardElement) {
                        const countSpan = cardElement.querySelector(".comment-count");
                        if (countSpan) {
                            countSpan.textContent = data.n_comments;
                        }
                    }
                }, 250);
            } else if (data.message) {
                alert(data.message);
            }
        } catch (err) {
            console.error("Error deleting comment:", err);
        }
    };

    /* ==========================================================================
       4. DELETE PHOTO MODAL & HANDLER (Private Gallery)
       ========================================================================== */
    const openDeletePhotoDialog = (card, src) => {
        if (!dialogDelPhoto || !src) return;
        photoPendingDelete = { card, src };
        if (dialogDelImg) dialogDelImg.src = src;
        dialogDelPhoto.showModal();
    };

    const closeDeletePhotoDialog = () => {
        if (dialogDelPhoto) dialogDelPhoto.close();
        photoPendingDelete = null;
    };

    if (btnCancelDelPhoto) {
        btnCancelDelPhoto.addEventListener("click", closeDeletePhotoDialog);
    }

    if (dialogDelPhoto) {
        dialogDelPhoto.addEventListener("click", (e) => {
            // Close when clicking the backdrop
            const rect = dialogDelPhoto.getBoundingClientRect();
            const isInDialog = (rect.top <= e.clientY && e.clientY <= rect.top + rect.height
                && rect.left <= e.clientX && e.clientX <= rect.left + rect.width);
            if (!isInDialog) closeDeletePhotoDialog();
        });
    }

    if (btnConfirmDelPhoto) {
        btnConfirmDelPhoto.addEventListener("click", async () => {
            if (!photoPendingDelete) return;

            const { card, src } = photoPendingDelete;
            btnConfirmDelPhoto.disabled = true;

            try {
                const response = await fetch("/api/delete_photo.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ src })
                });

                const data = await response.json();

                if (data.success) {
                    closeDeletePhotoDialog();
                    card.classList.add("fade-out");
                    setTimeout(() => {
                        card.remove();
                        currentOffset = Math.max(0, currentOffset - 1);
                        if (galleryGrid.querySelectorAll(".gallery-card").length === 0) {
                            if (emptyMsg) emptyMsg.classList.remove("hidden");
                            if (paginationContainer) paginationContainer.classList.add("hidden");
                        }
                    }, 300);
                } else if (data.message) {
                    alert(data.message);
                }
            } catch (err) {
                console.error("Error deleting photo:", err);
            } finally {
                btnConfirmDelPhoto.disabled = false;
            }
        });
    }

    /* ==========================================================================
       5. EVENT DELEGATION ON GALLERY GRID
       ========================================================================== */
    galleryGrid.addEventListener("click", async (e) => {
        // A) Click on Like Button
        const btnLike = e.target.closest(".btn-like");
        if (btnLike) {
            e.preventDefault();
            const card = btnLike.closest(".gallery-card");
            if (!card) return;
            const photoId = card.dataset.photoId;
            const overlay = card.querySelector(".heart-pulse-overlay");
            await toggleLike(photoId, btnLike, overlay);
            return;
        }

        // B) Click on Comment Button (Focus comment input)
        const btnComment = e.target.closest(".btn-comment");
        if (btnComment) {
            e.preventDefault();
            const card = btnComment.closest(".gallery-card");
            if (!card) return;
            const input = card.querySelector(".comment-input");
            if (input) {
                input.focus();
                input.scrollIntoView({ behavior: "smooth", block: "nearest" });
            }
            return;
        }

        // C) Click on Delete Comment Button
        const btnDelComment = e.target.closest(".btn-del-comment");
        if (btnDelComment) {
            e.preventDefault();
            const item = btnDelComment.closest(".comment-item");
            const card = btnDelComment.closest(".gallery-card");
            const commentId = item?.dataset.commentId;
            if (commentId && item && card) {
                await deleteComment(commentId, item, card);
            }
            return;
        }

        // D) Click on Delete Photo Button (Private Gallery)
        const btnDelPhoto = e.target.closest(".btn-del-photo");
        if (btnDelPhoto) {
            e.preventDefault();
            const card = btnDelPhoto.closest(".gallery-card");
            const src = btnDelPhoto.dataset.src;
            if (card && src) {
                openDeletePhotoDialog(card, src);
            }
            return;
        }
    });

    /* Double click / tap on photo to like */
    galleryGrid.addEventListener("dblclick", (e) => {
        const img = e.target.closest(".gallery-img");
        if (!img) return;

        const card = img.closest(".gallery-card");
        if (!card) return;

        const photoId = card.dataset.photoId;
        const btnLike = card.querySelector(".btn-like");
        const overlay = card.querySelector(".heart-pulse-overlay");

        // Trigger animation
        if (overlay) {
            overlay.classList.remove("animate");
            void overlay.offsetWidth;
            overlay.classList.add("animate");
        }

        // If not already liked, toggle it
        if (btnLike && !btnLike.classList.contains("liked")) {
            toggleLike(photoId, btnLike, overlay);
        }
    });

    /* ==========================================================================
       6. COMMENT FORM SUBMISSION
       ========================================================================== */
    galleryGrid.addEventListener("submit", async (e) => {
        const form = e.target.closest(".comment-form");
        if (!form) return;

        e.preventDefault();

        if (!isLoggedIn) {
            window.location.href = loginUrl;
            return;
        }

        const card = form.closest(".gallery-card");
        if (!card) return;

        const photoId = card.dataset.photoId;
        const input = form.querySelector(".comment-input");
        const submitBtn = form.querySelector(".btn-send-comment");
        const commentText = (input?.value || "").trim();

        if (!commentText || commentText.length > 255) return;

        if (submitBtn) submitBtn.disabled = true;

        try {
            const response = await fetch("/api/comment.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify({
                    photo_id: parseInt(photoId, 10),
                    comment: commentText
                })
            });

            const data = await response.json();

            if (data.success && data.comment) {
                // Clear input
                input.value = "";

                // Update comments list
                const list = card.querySelector(".comments-list");
                if (list) {
                    const noMsg = list.querySelector(".no-comments-msg");
                    if (noMsg) noMsg.remove();

                    const item = document.createElement("div");
                    item.className = "comment-item";
                    item.dataset.commentId = data.comment.id;
                    item.innerHTML = `
                        <div class="comment-content">
                            <strong class="comment-user">${escapeHtml(data.comment.user)}</strong>
                            <span class="comment-text">${escapeHtml(data.comment.text)}</span>
                        </div>
                        <button type="button" class="btn-del-comment" title="Eliminar comentario" aria-label="Eliminar">&times;</button>
                    `;
                    list.appendChild(item);
                    list.scrollTop = list.scrollHeight;
                }

                // Update comment counter in card actions
                const countSpan = card.querySelector(".comment-count");
                if (countSpan) {
                    countSpan.textContent = data.n_comments;
                }
            } else if (data.message) {
                alert(data.message);
            }
        } catch (err) {
            console.error("Error submitting comment:", err);
        } finally {
            if (submitBtn) submitBtn.disabled = false;
        }
    });

    /* ==========================================================================
       7. LOAD MORE PAGINATION
       ========================================================================== */
    if (btnLoadMore) {
        btnLoadMore.addEventListener("click", async () => {
            const spinner = btnLoadMore.querySelector(".spinner");
            const btnText = btnLoadMore.querySelector(".btn-text");

            btnLoadMore.disabled = true;
            if (spinner) spinner.classList.remove("hidden");

            try {
                const response = await fetch(`/api/gallery.php?offset=${currentOffset}&type=${encodeURIComponent(galleryType)}`, {
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                });

                const data = await response.json();

                if (data.success && Array.isArray(data.photos)) {
                    if (data.photos.length > 0) {
                        data.photos.forEach((photo) => {
                            const cardHtml = renderCard(photo);
                            galleryGrid.insertAdjacentHTML("beforeend", cardHtml);
                        });

                        currentOffset += data.photos.length;
                    }

                    if (!data.has_more || data.photos.length === 0) {
                        if (paginationContainer) paginationContainer.classList.add("hidden");
                        if (endMsg && currentOffset > 0) endMsg.classList.remove("hidden");
                    }
                }
            } catch (err) {
                console.error("Error loading more photos:", err);
            } finally {
                btnLoadMore.disabled = false;
                if (spinner) spinner.classList.add("hidden");
            }
        });
    }

    /* ==========================================================================
       8. RENDER CARD TEMPLATE HELPER
       ========================================================================== */
    const renderCard = (info) => {
        const username = escapeHtml(info.username || "User");
        const initial = username.charAt(0).toUpperCase() || "U";
        const isLiked = Boolean(info.user_liked);
        const heartIcon = isLiked ? "❤️" : "🤍";
        const likedClass = isLiked ? "liked" : "";
        const formattedDate = info.created_at ? new Date(info.created_at).toLocaleDateString() : "";

        let commentsHtml = "";
        if (info.comments && info.comments.length > 0) {
            info.comments.forEach((c) => {
                const delBtn = c.can_delete
                    ? `<button type="button" class="btn-del-comment" title="Eliminar comentario" aria-label="Eliminar">&times;</button>`
                    : "";
                commentsHtml += `
                    <div class="comment-item" data-comment-id="${c.id}">
                        <div class="comment-content">
                            <strong class="comment-user">${escapeHtml(c.user)}</strong>
                            <span class="comment-text">${escapeHtml(c.text)}</span>
                        </div>
                        ${delBtn}
                    </div>
                `;
            });
        } else {
            commentsHtml = '<p class="no-comments-msg">Aún no hay comentarios. ¡Sé el primero!</p>';
        }

        let formHtml = "";
        if (isLoggedIn) {
            formHtml = `
                <form class="comment-form" autocomplete="off">
                    <input type="text" name="comment" class="comment-input" placeholder="Escribe un comentario..." maxlength="255" required>
                    <button type="submit" class="btn-send-comment" title="Enviar">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </button>
                </form>
            `;
        } else {
            formHtml = `
                <div class="gallery-login-prompt">
                    <a href="${loginUrl}">Iniciar sesión</a> para comentar o dar like
                </div>
            `;
        }

        const deletePhotoBtn = galleryType === "private"
            ? `<button type="button" class="btn-del-photo" data-src="${escapeHtml(info.src)}" title="Eliminar foto" aria-label="Eliminar foto">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg>
               </button>`
            : "";

        return `
            <article class="gallery-card card" data-photo-id="${info.id}">
                <header class="gallery-card-header">
                    <div class="user-info">
                        <div class="user-avatar-placeholder">${initial}</div>
                        <span class="user-name">${username}</span>
                    </div>
                    <div class="header-meta">
                        ${formattedDate ? `<time class="post-date">${formattedDate}</time>` : ""}
                        ${deletePhotoBtn}
                    </div>
                </header>

                <div class="gallery-image-wrapper">
                    <img src="${escapeHtml(info.src)}" alt="Foto de ${username}" loading="lazy" class="gallery-img">
                    <div class="heart-pulse-overlay" aria-hidden="true">❤️</div>
                </div>

                <div class="gallery-card-actions">
                    <button type="button" class="action-btn btn-like ${likedClass}" aria-label="Me gusta">
                        <span class="heart-icon">${heartIcon}</span>
                        <span class="like-count">${info.n_likes || 0}</span>
                    </button>

                    <button type="button" class="action-btn btn-comment" aria-label="Comentarios">
                        <span class="comment-icon">💬</span>
                        <span class="comment-count">${info.n_comments || 0}</span>
                    </button>
                </div>

                <div class="gallery-comments-section">
                    <div class="comments-list">
                        ${commentsHtml}
                    </div>
                    ${formHtml}
                </div>
            </article>
        `;
    };
});
