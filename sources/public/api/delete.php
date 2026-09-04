<?php

ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

Lang::setLang($_SESSION['lang'] ?? 'en');

try
{
    if (!Auth::check())
        throw new FormException(401);

    $userId = (int)$_SESSION['user']['id'];
    $inputPass = $_POST['password'] ?? '';

    if (empty($inputPass))
        throw new FormException(422, null, ['password' => Lang::t('form.void')]);

    $model = new UserModel();

    // Get password
    $pass = $model->getPass($userId);
    if ($pass === false || empty($pass))
        throw new FormException(500, Lang::t('500.db'));

    // Check password
    if (!password_verify($inputPass, $pass['password_hash']))
        throw new FormException(422, null, ['password' => Lang::t('422.pass')]);

    // Delete account in db
    if (!$model->deleteAccount($userId))
        throw new FormException(500, Lang::t('500.delete'));

    // Delete user folder
    Utils::removeFolder();
    // Logout and clear session/cookie
    Auth::logout();
    
    Navigator::ajaxRedirection("signin");
}
catch (FormException $e)
{
    http_response_code($e->getCode());
    echo json_encode(
    [
        'success'  => false,
        'message'  => $e->getMessage(), // Container
        'errors'   => $e->getErrors(), // Span
        'redirect' => null
    ]);
    exit ;
}
catch (Throwable $e)
{
    http_response_code(500);
    echo json_encode(
    [
        'success'  => false,
        'message'  => $e->getMessage(), // Container
        'errors'   => [], // Span
        'redirect' => null
    ]);
    exit ;
}