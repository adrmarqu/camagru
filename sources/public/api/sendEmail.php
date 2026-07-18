<?php

session_start();

require_once __DIR__ . '/../../app/bootstrap.php';

Lang::setLang(Lang::getLang());

if (!isset($_SESSION['send_email']))
{
    // Error
}

$s = $_SESSION['send_email'];

$action = $s['action'];

switch ($action)
{
    case 'account':

        // Generar token
        // Enviar email

        break;
    case 'email':

        // Generar token
        // Enviar email
        
        break;

}

$email = $s['email'];
$action = $s['user_id'];
