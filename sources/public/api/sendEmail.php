<?php

session_start();
ini_set('display_errors', '0');

require_once __DIR__ . '/../../app/bootstrap.php';

Lang::setLang(Lang::getLang());

header('Content-Type: application/json');

if (!isset($_SESSION['send_email']))
{
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => ['global' => Lang::t('400.message')]]);
    exit;
}

$s = $_SESSION['send_email'];

$action = $s['action'] ?? null;
$userid = $s['user_id'] ?? null;
$email = $s['email'] ?? null;

$model = new TokenModel();

$db = Database::getConnection();
$db->beginTransaction();

if ($action === 'account')
{
    $newToken = $model->generateToken($userid, 'account', (10 * 60));

    if (empty($newToken))
    {
        $db->rollBack();
        http_response_code(500);
        echo json_encode(['success' => false, 'errors' => ['global' => Lang::t('500.message')]]);
        exit;
    }

    if (SendEmail::account($email, $newToken))
    {
        $db->commit();
        $_SESSION['send_email']['token'] = $newToken;
        echo json_encode(['success' => true]);
        exit;
    }

    $db->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'errors' => ['global' => Lang::t('500.message')]]);
    exit;
}

$db->rollBack();
http_response_code(400);
echo json_encode(['success' => false, 'errors' => ['global' => Lang::t('400.message')]]);
exit;