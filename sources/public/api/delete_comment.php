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

$commentId = (int)($data['comment_id'] ?? $_POST['comment_id'] ?? 0);

if ($commentId <= 0)
{
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => Lang::t('400.data')
    ]);
    exit;
}

$userId = (int)$_SESSION['user']['id'];

try
{
    $media = new MediaModel();
    
    // Check if comment exists and get photo_id
    $comment = $media->getComment($commentId);
    if (!$comment)
    {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Comentario no encontrado.'
        ]);
        exit;
    }

    $photoId = (int)$comment['photo_id'];

    // Attempt delete with permission check
    $deleted = $media->deleteComment($commentId, $userId);

    if (!$deleted)
    {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'No tienes permiso para eliminar este comentario.'
        ]);
        exit;
    }

    $totalComments = $media->countComments($photoId);

    http_response_code(200);
    echo json_encode([
        'success'    => true,
        'comment_id' => $commentId,
        'photo_id'   => $photoId,
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
