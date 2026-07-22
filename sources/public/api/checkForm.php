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
        $login = new LoginController();
        $errors = $login->checkFormat($_POST['usermail'] ?? '', $_POST['password'] ?? '');
        break;
    case 'signin':
        $signin = new SigninController();
        $errors = $signin->checkFormat($_POST['user'] ?? '', $_POST['email'] ?? '', $_POST['password'] ?? '', $_POST['confirm'] ?? '', isset($_POST['terms']));
        break;
    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => ['global' => Lang::t('400.message')]]);
        exit;
}

if (!empty($errors))
{
    http_response_code(422);
    if (!isset($errors['global']))
        $errors['global'] = Lang::t('422.message');
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

echo json_encode(['success' => true]);