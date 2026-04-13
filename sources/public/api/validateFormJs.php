<?php

define('ROOT', '/var/www/sources/');

header('Content-Type: application/json; charset=utf-8');

require_once ROOT . 'validation/FormValidation.php';
require_once ROOT . 'view/languages/sources.php';

$validation = new FormValidation($_POST);
$result = $validation->checkForm($_POST['formName'], $lang);

echo json_encode($result);