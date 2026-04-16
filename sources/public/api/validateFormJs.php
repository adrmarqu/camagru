<?php

require_once dirname(__DIR__, 2) . '/app/core/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');

require_once BACKEND . 'validation/FormValidation.php';
require_once BACKEND . 'view/languages/sources.php';
require_once BACKEND . 'utils/i18n.php';

$validation = new FormValidation();
$result = $validation->checkForm($_POST['formName'] ?? '', $_POST);

echo json_encode($result);