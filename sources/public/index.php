<?php 

define('ROOT', '/var/www/srcs/');

require_once ROOT . 'controllers/App.php';

$app = new App();
$app->run();