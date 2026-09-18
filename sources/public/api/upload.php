<?php

ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

Lang::setLang($_SESSION['lang'] ?? 'en');

// Get data
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

// Check data
if (!$data || !isset($data['image']) || empty($data['stickers']))
{
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => Lang::t('400.data')
    ]);
    exit;
}

// Get vars
$image = $data['image'];
$stickers = $data['stickers'];
$stage = $data['stage'] ?? null;

try
{
    $ctrl = new ImageController();
    $src = $ctrl->upload($image, $stickers, $stage);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => Lang::t('200.image_uploaded'),
        'src' => $src
    ]);
    exit;
}
catch (FormException $e)
{
    http_response_code($e->getCode());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}
catch (Throwable $e)
{
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}