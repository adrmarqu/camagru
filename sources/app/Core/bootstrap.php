<?php
// CORE
define('ROOT_PATH', dirname(dirname(__DIR__)));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// APP
define('LANG_PATH', APP_PATH . '/langs');
define('VIEW_PATH', APP_PATH . '/Views');
define('CORE_PATH', APP_PATH . '/Core');

// TEMPLATES
define('LAYOUT_TPL', VIEW_PATH . '/layouts');
define('AUTH_TPL', VIEW_PATH . '/auth');
define('CORE_TPL', VIEW_PATH . '/core');
define('PARTIAL_TPL', VIEW_PATH . '/partials');
define('USER_TPL', VIEW_PATH . '/user');
define('OTHERS_TPL', VIEW_PATH . '/others');

// PUBLIC
define('URL_UPLOAD', '/uploads');
define('URL_ASSETS', '/assets');
define('URL_CSS', '/css');
define('URL_JS', '/js');

// Environment
$envVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_ROOT_PASSWORD', 'APP_URL'];
foreach ($envVars as $var)
{
    $value = getenv($var);
    if ($value !== false)
        $_ENV[$var] = $value;
}

// Autoloader
spl_autoload_register(function ($className)
{
    $directories =
    [
        'Controllers/Main',
        'Controllers/Auth',
        'Controllers/Token',
        'Controllers',
        'Models',
        'Core',
        'Views',
        'Helpers',
        'Exceptions'
    ];
    
    foreach ($directories as $dir)
    {
        $file = APP_PATH . "/$dir/$className.php";
        if (file_exists($file)) break;
    }

    if (isset($file) && file_exists($file))
        require_once $file;
});