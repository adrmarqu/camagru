<?php

// sources/
define('ROOT_PATH', dirname(__DIR__));

// sources/app
define('APP_PATH', ROOT_PATH . '/app');

define('CTRL_PATH', APP_PATH . '/Controllers');
define('MODL_PATH', APP_PATH . '/Models');
define('VIEW_PATH', APP_PATH . '/Views');
define('HELP_PATH', APP_PATH . '/Helpers');
define('RSRC_PATH', APP_PATH . '/Resources');

// sources/app/Views
define('TPL_PATH', VIEW_PATH . '/templates');
define('LAYOUT_PATH', TPL_PATH . '/layouts');
define('PAGES_PATH', TPL_PATH . '/pages');
define('FORMS_PATH', TPL_PATH . '/forms');
define('ELEM_PATH', TPL_PATH . '/elements');

// sources/app/Resources
define('CONF_PATH', RSRC_PATH . '/Config');
define('LANG_PATH', RSRC_PATH . '/languages');


// sources/public
define('PUBLIC_PATH', ROOT_PATH . '/public');

define('URL_UPLOAD', PUBLIC_PATH . '/uploads');
define('URL_CSS', PUBLIC_PATH . '/css');
define('URL_JS', PUBLIC_PATH . '/js');

spl_autoload_register(function ($className)
{
    $directories = ['Controllers', 'Models', 'Views', 'Helpers', 'Core', 'Resources/Config'];
    
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