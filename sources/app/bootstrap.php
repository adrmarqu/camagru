<?php

// sources/
define('ROOT_PATH', dirname(__DIR__));

// sources/app
define('APP_PATH', ROOT_PATH . '/app');

define('CTRL_PATH', APP_PATH . '/Controllers');
define('MODEL_PATH', APP_PATH . '/Models');
define('VIEW_PATH', APP_PATH . '/Views');

// sources/app/Views
define('PAGES_PATH', VIEW_PATH . '/pages');
define('LANG_PATH', VIEW_PATH . '/languages');

// sources/public
define('PUBLIC_PATH', ROOT_PATH . '/public');

define('URL_UPLOAD', PUBLIC_PATH . '/uploads');
define('URL_CSS', PUBLIC_PATH . '/css');
define('URL_JS', PUBLIC_PATH . '/js');

spl_autoload_register(function ($className)
{
    $directories = ['Controllers', 'Models', 'Views', 'Helpers', 'Core'];
    
    foreach ($directories as $dir)
    {
        $file = APP_PATH . "/$dir/$className.php";
        if (file_exists($file))
        {
            require_once $file;
            return;
        }
    }
});