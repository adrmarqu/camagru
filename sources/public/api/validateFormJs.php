<?php

define('ROOT', dirname(__DIR__) . '/../');

header('Content-Type: application/json; charset=utf-8');

require_once ROOT . 'validation/FormValidation.php';
require_once ROOT . 'view/languages/sources.php';
require_once ROOT . 'utils/i18n.php';

$validation = new FormValidation();
$result = $validation->checkForm($_POST['formName'] ?? '', $_POST);

echo json_encode($result);