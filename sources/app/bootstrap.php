<?php
// /sources
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// /sources/app
define('CTRL_PATH', APP_PATH . '/Controllers');
define('MODL_PATH', APP_PATH . '/Models');
define('VIEW_PATH', APP_PATH . '/Views');
define('HELP_PATH', APP_PATH . '/Helpers');
define('RSRC_PATH', APP_PATH . '/Resources');

// /sources/app/Views
define('TPL_PATH', VIEW_PATH . '/templates');
define('PAGES_PATH', TPL_PATH . '/pages');
define('LAYOUT_PATH', TPL_PATH . '/layouts');
define('ELEM_PATH', TPL_PATH . '/elements');

// /sources/app/Resources
define('CONF_PATH', RSRC_PATH . '/Config');
define('LANG_PATH', RSRC_PATH . '/languages');

// /sources/public
define('URL_UPLOAD', '/uploads');
define('URL_ASSETS', '/assets');
define('URL_CSS', '/css');
define('URL_JS', '/js');

// Environment (las variables se inyectan por Docker via env_file)
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
        'Controllers',
        'Controllers/Gallery',
        'Controllers/Auth',
        'Controllers/Editor',
        'Controllers/Token',
        'Controllers/User',
        'Controllers/Error',
        'Models',
        'Core',
        'Views',
        'Helpers',
        'Resources/Config',
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