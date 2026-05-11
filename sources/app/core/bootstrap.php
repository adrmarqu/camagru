<?php

define('ROOT', dirname(__DIR__, 2) . '');

/* Public */

define('FRONTEND', '/');
define('ASSETS', '/media/assets');
define('UPLOADS', '/media/uploads');

/* Server */

define('BACKEND', ROOT . '/app/');
define('TEMPLATES', BACKEND . '/view/templates');
define('COMPONENTS', TEMPLATES . '/components');
define('SCREENS', TEMPLATES . '/screens');
define('LAYOUTS', TEMPLATES . '/layouts');
define('FORMS', TEMPLATES . '/forms');

/* Others */

define('TPL_PLACEHOLDER_PATTERN', '{{::%s::}}');
