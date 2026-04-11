<?php 

define('ROOT', '/var/www/sources/');

require_once ROOT . 'controller/App.php';

$app = new App();
$app->run();