<?php

session_start();

require_once __DIR__ . '/../../app/bootstrap.php';

/* Response always JSON */
header('Content-Type: application/json');

/* Only POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

/* Must be logged in */
if (!isset($_SESSION['user']['id']))
{
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$userId = (int) $_SESSION['user']['id'];

/* File must be present and without upload error */
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK)
{
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'No file uploaded or upload error']);
    exit;
}

$file     = $_FILES['avatar'];
$maxBytes = 2 * 1024 * 1024; // 2 MB

/* Check file size */
if ($file['size'] > $maxBytes)
{
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'File too large (max 2 MB)']);
    exit;
}

/* Validate MIME type using finfo (not trust $_FILES['type']) */
$finfo    = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($file['tmp_name']);
$allowed  = ['image/jpeg', 'image/png', 'image/webp'];

if (!in_array($mimeType, $allowed, true))
{
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Invalid file type (jpeg, png, webp only)']);
    exit;
}

/* Create upload directory if it doesn't exist */
$uploadDir = __DIR__ . '/../uploads/' . $userId . '/';
if (!is_dir($uploadDir))
    mkdir($uploadDir, 0755, true);

/* Load source image with GD depending on MIME */
$source = match ($mimeType)
{
    'image/jpeg' => imagecreatefromjpeg($file['tmp_name']),
    'image/png'  => imagecreatefrompng($file['tmp_name']),
    'image/webp' => imagecreatefromwebp($file['tmp_name']),
};

if ($source === false)
{
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Could not process image']);
    exit;
}

/* Get original dimensions */
$srcW = imagesx($source);
$srcH = imagesy($source);

/* Crop to square (center crop) */
$squareSize = min($srcW, $srcH);
$srcX       = (int)(($srcW - $squareSize) / 2);
$srcY       = (int)(($srcH - $squareSize) / 2);

/* Create 200x200 destination image */
$dest = imagecreatetruecolor(200, 200);

/* Preserve transparency for PNG/WebP */
if ($mimeType === 'image/png' || $mimeType === 'image/webp')
{
    imagealphablending($dest, false);
    imagesavealpha($dest, true);
    $transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
    imagefilledrectangle($dest, 0, 0, 200, 200, $transparent);
}

/* Resize cropped square to 200x200 */
imagecopyresampled($dest, $source, 0, 0, $srcX, $srcY, 200, 200, $squareSize, $squareSize);

/* Save as JPEG (always, for consistency) */
$filename   = 'avatar.jpg';
$outputPath = $uploadDir . $filename;

if (!imagejpeg($dest, $outputPath, 85))
{
    imagedestroy($source);
    imagedestroy($dest);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Could not save image']);
    exit;
}

imagedestroy($source);
imagedestroy($dest);

/* Update DB */
try
{
    $model = new UserModel();
    $model->updateAvatar($userId, $filename);
}
catch (Throwable $e)
{
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error']);
    exit;
}

/* Update session so the header updates immediately */
$_SESSION['user']['avatar'] = $filename;

/* Return the new avatar URL with a cache-buster timestamp */
$avatarUrl = '/uploads/' . $userId . '/' . $filename . '?v=' . time();
echo json_encode(['success' => true, 'avatarUrl' => $avatarUrl]);
