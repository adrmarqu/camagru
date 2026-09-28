<?php

ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

Lang::setLang($_SESSION['lang'] ?? 'en');

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => Lang::t('405.message')
    ]);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user']['id']))
{
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => Lang::t('401.message')
    ]);
    exit;
}

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

$photoId = (int)($data['photo_id'] ?? $_POST['photo_id'] ?? 0);
$commentText = trim($data['comment'] ?? $data['text'] ?? $_POST['comment'] ?? $_POST['text'] ?? '');

if ($photoId <= 0 || $commentText === '')
{
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => Lang::t('400.data')
    ]);
    exit;
}

if (mb_strlen($commentText, 'UTF-8') > 255)
{
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'El comentario no puede superar los 255 caracteres.'
    ]);
    exit;
}

$userId = (int)$_SESSION['user']['id'];
$username = $_SESSION['user']['name'] ?? $_SESSION['user']['username'] ?? Auth::username();

try
{
    $media = new MediaModel();
    $commentId = $media->writeComment($userId, $photoId, $commentText);

    if (!$commentId)
    {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => Lang::t('500.db')
        ]);
        exit;
    }

    // Check if notification email should be sent to photo owner
    $owner = $media->getPhotoOwner($photoId);
    if ($owner && !empty($owner['notification_active']) && (int)$owner['id'] !== $userId && !empty($owner['email']))
    {
        Mailer::sendCommentNotification(
            $owner['email'],
            $owner['username'] ?? 'Camagruer',
            $username,
            $commentText
        );
    }

    $totalComments = $media->countComments($photoId);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'comment' => [
            'id'         => $commentId,
            'user'       => $username,
            'text'       => $commentText,
            'created_at' => date('Y-m-d H:i:s'),
            'can_delete' => true
        ],
        'n_comments' => $totalComments
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
