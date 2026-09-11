<?php

ini_set('display_errors', 0);
header('Content-Type: application/json');

require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

Lang::setLang($_SESSION['lang'] ?? 'en');

// Check if its POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => Lang::t('405.message')]);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user']['id']) || !isset($_SESSION['user']['folder']))
{
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => Lang::t('401.message')]);
    exit;
}

// Check if you have the image
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK)
{
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => Lang::t('400.not_image')]);
    exit;
}

$file = $_FILES['avatar'];
$tmp = $file['tmp_name'];

try
{
    $image = new ImageController();
    $path = $image->changeAvatar($tmp);

    http_response_code(200);
    echo json_encode(
    [
        'success' => true,
        'src' => $path,
        'message' => Lang::t('200.avatar')
    ]);
}
catch (Throwable $e)
{
    $code = ($e->getCode() >= 100 && $e->getCode() < 600) ? (int)$e->getCode() : 500;
    http_response_code($code);
    echo json_encode(
    [
        'success' => false,
        'message' => $e->getMessage()
    ]);
}