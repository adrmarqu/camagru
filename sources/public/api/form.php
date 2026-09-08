<?php

ini_set('display_errors', 0);
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

Lang::setLang($_SESSION['lang'] ?? 'en');

function message(int $code, string $msg, array $err = [], ?string $red = null): void
{
    http_response_code($code);
    echo json_encode(
    [
        'success' => $code === 200,
        'message' => $msg, // Container
        'errors' => $err, // Span
        'redirect' => $red
    ]);
    exit ;
}

try
{
    $action = $_POST['action'] ?? null;

    switch ($action)
    {
        case 'login':
            $controller = new LoginController();
            $redirect = 'gallery';
            break ;
        case 'signin':
            $controller = new SigninController();
            $redirect = 'send-email';
            break ;
        /* Email for send-email */
        case 'forgot':
            $controller = new ForgotController();
            $redirect = 'send-email';
            break ;
        /* New password (pass + confirm) */
        case 'reset':
            $controller = new ResetController();
            $redirect = 'result?type=reset';
            break ;
        /* Send email */
        case 'send':
            $controller = new SendController();
            $redirect = 'send-email';
            break ;
        /* Profile - user & email */
        case 'user':
            $controller = new ProfileController();
            $redirect = null;
            break ;
        /* Profile - password */
        case 'password':
            $controller = new ProfileController();
            $redirect = null;
            break ;
        /* Profile - notifications */
        case 'preferences':
            $controller = new ProfileController();
            $redirect = null;
            break ;
        default:
            throw new FormException(404, Lang::t('404.action'));
    }
    $controller->init($_POST);
    $controller->validate();
    $message = $controller->execute(); 
    
    if ($redirect !== null)
        Navigator::ajaxRedirection($redirect);
    else
        message(200, $message ?? '');
}
/* Errors */
catch(FormException $e)
{
    message($e->getCode(), $e->getMessage(), $e->getErrors(), $e->getRedir());
}
/* Unknown errors */
catch(Throwable $e)
{
    message(500, $e->getMessage());
}