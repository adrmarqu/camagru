<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

Lang::setLang($_SESSION['lang'] ?? 'en');

Auth::logout();

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
{
    Navigator::ajaxRedirection('login');
}
else
{
    Navigator::redirect('login', 302);
}