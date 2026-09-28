<?php

ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

Lang::setLang($_SESSION['lang'] ?? 'en');

$offset = max(0, (int)($_GET['offset'] ?? 0));
$userId = $_SESSION['user']['id'] ?? null;
$type = $_GET['type'] ?? 'gallery';

try
{
    $media = new MediaModel();
    $currentUserId = $userId ? (int)$userId : 0;

    if ($type === 'favorites')
    {
        if ($currentUserId <= 0)
        {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => Lang::t('401.message')]);
            exit;
        }
        $images = $media->getFavoriteImages($currentUserId, $offset) ?: [];
    }
    else if ($type === 'private')
    {
        if ($currentUserId <= 0)
        {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => Lang::t('401.message')]);
            exit;
        }
        $images = $media->getPrivateImages($currentUserId, $offset) ?: [];
    }
    else
    {
        $images = $media->getImages($offset, $currentUserId > 0 ? $currentUserId : null) ?: [];
    }
    $photoData = [];
    foreach ($images as $photo)
    {
        $comments = $media->getComments((int)$photo['id']) ?: [];
        $photoAuthorId = (int)$photo['user_id'];
        $formattedComments = [];
        foreach ($comments as $c)
        {
            $commentUserId = (int)$c['user_id'];
            $canDelete = $currentUserId > 0 && ($commentUserId === $currentUserId || $photoAuthorId === $currentUserId);

            $formattedComments[] = [
                'id'         => (int)$c['id'],
                'user_id'    => $commentUserId,
                'user'       => htmlspecialchars($c['user'] ?? $c['username'] ?? '', ENT_QUOTES, 'UTF-8'),
                'text'       => htmlspecialchars($c['text'] ?? $c['comment'] ?? '', ENT_QUOTES, 'UTF-8'),
                'created_at' => $c['created_at'] ?? '',
                'can_delete' => $canDelete
            ];
        }

        $photoData[] = [
            'id'          => (int)$photo['id'],
            'user_id'     => $photoAuthorId,
            'src'         => $photo['src'],
            'username'    => htmlspecialchars($photo['username'] ?? 'User', ENT_QUOTES, 'UTF-8'),
            'created_at'  => $photo['created_at'] ?? '',
            'n_likes'     => (int)$photo['n_likes'],
            'n_comments'  => (int)$photo['n_comments'],
            'user_liked'  => !empty($photo['user_liked']),
            'comments'    => $formattedComments
        ];
    }

    http_response_code(200);
    echo json_encode([
        'success'    => true,
        'photos'     => $photoData,
        'count'      => count($photoData),
        'has_more'   => count($photoData) >= 6
    ]);
    exit;
}
catch (Throwable $e)
{
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => Lang::t('500.db')
    ]);
    exit;
}
