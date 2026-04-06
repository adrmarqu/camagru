<?php

require_once __DIR__ . '/AuthController.php';

const TPL_GAL = __DIR__ . '/../views/tpls/screens/gallery.tpl';

$page = $_GET['page'] ?? 'login';

switch ($page)
{
    case 'gallery':
        $html = getHtml(TPL_GAL, []);
        showTPL("Gallery", $html);
        break ;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'signin':
        $controller = new AuthController();
        $controller->signin();
        break;
    default:
        echo "Page not found";
}