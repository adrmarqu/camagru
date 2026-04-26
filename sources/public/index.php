<?php 

require_once dirname(__DIR__) . '/app/core/bootstrap.php';

require_once BACKEND . '/core/App.php';

$app = new App();
$app->run();