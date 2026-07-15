<?php

session_start();

require_once __DIR__ . '/../../app/bootstrap.php';

Lang::setLang(Lang::getLang());

/* Response always json */
header('Content-Type: application/json');

/* Only accepted POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    http_response_code(405);
    echo json_encode(['success' => false, 'errors' => ['global' => Lang::t("405.message")]]);
    exit;
}

$formType = $_POST['form_type'] ?? '';
$errors = [];

switch ($formType)
{
    case 'login':
        $errors = AuthService::login($_POST['usermail'] ?? '', $_POST['password'] ?? '');
        break;
    case 'signin':
        $errors = AuthService::signin($_POST['user'] ?? '', $_POST['email'] ?? '', $_POST['password'] ?? '', $_POST['confirm'] ?? '', isset($_POST['terms']));
        break;
    case 'forgot':
        $errors = AuthService::forgotPass($_POST['usermail'] ?? '');
        break;
    case 'reset':
        $errors = AuthService::resetPass($_POST['password'] ?? '', $_POST['confirm'] ?? '');
        break;
    case 'user':
        $errors = AuthService::user($_POST['user'] ?? '');
        break;
    case 'password':
        $errors = AuthService::password($_POST['password'] ?? '', $_POST['new_password'] ?? '', ['new_password_confirm'] ?? '');
        break;
    case 'email':
        $errors = AuthService::email($_POST['email'] ?? '');
        break;
    default:
        sendError(400);
}

if (!empty($errors))
{
    http_response_code(422);
    if (!isset($errors['global'])) {
        $errors['global'] = Lang::t('422.message');
    }
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

echo json_encode(['success' => true]);