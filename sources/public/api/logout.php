<?php

session_start();

require_once __DIR__ . '/../../app/bootstrap.php';

Lang::setLang(Lang::getLang());

AuthHelper::logout();
Navigator::redirect('gallery');