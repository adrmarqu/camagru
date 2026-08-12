<?php

require_once __DIR__ . '/../../app/Core/bootstrap.php';

if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

Auth::logout();