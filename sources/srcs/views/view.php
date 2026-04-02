<?php

const TPL_GAL = __DIR__ . '/tpls/screens/gallery.tpl';
const TPL_EDI = __DIR__ . '/tpls/screens/editor.tpl';
const TPL_LOG = __DIR__ . '/tpls/screens/login.tpl';
const TPL_VER = __DIR__ . '/tpls/screens/verify.tpl';

const TPL_TOP = __DIR__ . '/tpls/components/head.tpl';
const TPL_HEA = __DIR__ . '/tpls/components/header.tpl';
const TPL_FOO = __DIR__ . '/tpls/components/footer.tpl';

const TPL_PLACEHOLDER_PATTERN = '{{::%s::}}';

function showTPL(array $data, string $fileName)
{
    if (!is_readable($fileName))
    {
        echo "It can't load the screen required";
        exit();
    }

    $html = file_get_contents(TPL_TOP);
    $html .= file_get_contents(TPL_HEA);
    $html .= file_get_contents($fileName);
    $html .= file_get_contents(TPL_FOO);

    foreach ($data as $key => $value)
    {
        $placeholder = sprintf(TPL_PLACEHOLDER_PATTERN, $key);
        $html = str_replace($placeholder, (string)$value, $html);
    }
    echo $html;
    exit();
}

function viewGallery()
{
    $arr = getArrayData("Gallery");
    showTPL($arr, TPL_GAL);
}

function viewLogin()
{
    $arr = getArrayData("Login");
    showTPL($arr, TPL_LOG);
}

function viewVerfify()
{
    $arr = getArrayData("Verify");
    showTPL($arr, TPL_VER);
}

function viewEditor()
{
    $arr = getArrayData("Editor");
    showTPL($arr, TPL_EDI);
}

function getArrayData(string $title, bool $login, bool $signin)
{
    /* Language */

    $allowedLangs = ['en', 'ca', 'es'];
    $lang = $_GET['lang'] ?? $_COOKIE['language'] ?? 'en'; 
    if (!in_array($lang, $allowedLangs))
        $lang = 'en';

    /* Login - Signin */

    if ($login === true || $signin === true)
    {
        $user = 'Nombre de usuario';
        $pass = 'Contraseña';
    }

    /* if ($signin === true)
    {
        $email = 'Nombre de usuario sign';
        $repeat = 'Nombre de usuario sign';
    } */

    $array = 
    [
        'language' => $lang,
        'title' => $title,
        'script' => null,
        'formUser' => $user,
        'formPass' => $pass
    ];

    return $array;
}