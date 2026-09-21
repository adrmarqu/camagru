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
if (!isset($_SESSION['user']['id']) || !isset($_SESSION['user']['folder']))
{
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => Lang::t('401.message')
    ]);
    exit;
}

// Get data (support JSON body or POST form data)
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

$src = $data['src'] ?? $data['filename'] ?? $_POST['src'] ?? $_POST['filename'] ?? null;

if (empty($src))
{
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => Lang::t('400.data')
    ]);
    exit;
}

try
{
    $ctrl = new ImageController();
    $ctrl->deletePhoto($src);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => Lang::t('200.image_deleted') ?? 'Foto eliminada con éxito.'
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
