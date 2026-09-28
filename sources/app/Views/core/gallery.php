<?php

$h1 = Lang::t('title.gallery');
$model = new MediaModel();
$userId = $_SESSION['user']['id'] ?? null;
$images = $model->getImages(0, $userId ? (int)$userId : null) ?: [];
$photoData = [];

$currentUserId = $userId ? (int)$userId : 0;

foreach ($images as $photo)
{
    $comments = $model->getComments((int)$photo['id']) ?: [];
    $photoAuthorId = (int)$photo['user_id'];
    $formattedComments = [];
    foreach ($comments as $c)
    {
        $commentUserId = (int)$c['user_id'];
        $canDelete = $currentUserId > 0 && ($commentUserId === $currentUserId || $photoAuthorId === $currentUserId);

        $formattedComments[] = [
            'id'         => (int)$c['id'],
            'user_id'    => $commentUserId,
            'user'       => $c['user'] ?? $c['username'] ?? '',
            'text'       => $c['text'] ?? $c['comment'] ?? '',
            'created_at' => $c['created_at'] ?? '',
            'can_delete' => $canDelete
        ];
    }

    $photoData[] = [
        'id'          => (int)$photo['id'],
        'user_id'     => $photoAuthorId,
        'src'         => $photo['src'],
        'username'    => $photo['username'] ?? 'User',
        'created_at'  => $photo['created_at'] ?? '',
        'n_likes'     => (int)$photo['n_likes'],
        'n_comments'  => (int)$photo['n_comments'],
        'user_liked'  => !empty($photo['user_liked']),
        'comments'    => $formattedComments
    ];
}

require_once __DIR__ . '/baseGallery.php';