<?php

session_start();

require_once __DIR__ . '/../../app/bootstrap.php';

Lang::setLang(Lang::getLang());

$cookie = new CookieController();
$cookie->logout();
Navigator::redirect('gallery');