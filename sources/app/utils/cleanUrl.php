<?php

require_once BACKEND . 'view/languages/sources.php';
require_once BACKEND . 'utils/i18n.php';
require_once BACKEND . 'core/App.php';

/* Pagina solicitada */
$page = $_GET['page'] ?? 'login';
$page = strtolower($page);
$page = preg_replace('/[^a-z0-9-]/', '', $page);

/* Normalizar uri sin query string */
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestPath = rtrim($requestPath, '/');

/* Idioma actual */
$language = getLanguage(['en', 'ca', 'es']);

/* url canonica */
$canonical = '/' . $language . '/' . $page;

/* Redireccion si es diferente */
if ($requestPath !== $canonical) {
    header('Location: ' . $canonical, true, 301);
    exit;
}

/* Ejecutar app */
$app = new App();
$app->run($page);