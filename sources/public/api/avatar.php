<?php

ini_set('display_errors', 0);
header('Content-Type: application/json');

require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

Lang::setLang($_SESSION['lang'] ?? 'en');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => Lang::t('405.message')]);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user']['id']))
{
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => Lang::t('401.message')]);
    exit;
}

// Check if avatar image file was uploaded
if (!isset($_FILES['avatar']))
{
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => Lang::t('400.not_image')]);
    exit;
}

$file = $_FILES['avatar'];

if ($file['error'] !== UPLOAD_ERR_OK)
{
    $msg = ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE)
        ? Lang::t('400.size_image')
        : Lang::t('400.not_image');

    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

if (!is_uploaded_file($file['tmp_name']) && !file_exists($file['tmp_name']))
{
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => Lang::t('400.not_image')]);
    exit;
}

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