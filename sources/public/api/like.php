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

if ($photoId <= 0)
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
    $liked = false;

    if ($media->hasLiked($userId, $photoId))
    {
        $media->deleteLike($userId, $photoId);
        $liked = false;
    }
    else
    {
        $media->like($userId, $photoId);
        $liked = true;
    }

    $totalLikes = $media->countLikes($photoId);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'liked'   => $liked,
        'n_likes' => $totalLikes
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
