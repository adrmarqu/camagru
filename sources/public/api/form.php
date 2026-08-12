<?php

header('Content-Type: application/json');
require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

Lang::setLang($_SESSION['lang'] ?? 'es');

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
            break ;
        case 'signin':
            $controller = new SigninController();
            break ;
        /* Email for send-email */
        case 'forgot':
            $controller = new ForgotController();
            break ;
        /* New password (pass + confirm) */
        case 'reset':
            $controller = new ResetController();
            break ;
        /* Send email */
        case 'send':
            $controller = new SendController();
            break ;
        default:
            throw new FormException(404, [], Lang::t('404.action'));
    }
    $controller->init($_POST);
    $controller->validate();
    $controller->execute();
    
    message(200, '', [], '/gallery');
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