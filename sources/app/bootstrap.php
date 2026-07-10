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
define('URL_CSS', '/css');
define('URL_JS', '/js');

// Environment
$envPath = dirname(ROOT_PATH) . '/.env';
if (file_exists($envPath))
{
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line)
    {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// Autoloader
spl_autoload_register(function ($className)
{
    $directories = ['Controllers', 'Models', 'Core', 'Views', 'Helpers', 'Resources/Config'];
    foreach ($directories as $dir)
    {
        $file = APP_PATH . "/$dir/$className.php";
        if (file_exists($file)) break;
    }

    if (isset($file) && file_exists($file))
        require_once $file;
});