<?php

define('ROOT', dirname(__DIR__, 2) . '');

/* Public */

define('FRONTEND', '/');
define('MEDIA', '/media');
define('ASSETS', MEDIA . '/assets');
define('UPLOADS', MEDIA . '/uploads');

/* Server */

define('BACKEND', ROOT . '/app');

/* Controllers */

define('CONTROLLERS', BACKEND . '/controllers');
define('C_AUTH', CONTROLLERS . '/auth');
define('C_MAIN', CONTROLLERS . '/main');
define('C_USER', CONTROLLERS . '/user');

/* Core */

define('CORE', BACKEND . '/core');
define('VALIDATIONS', BACKEND . '/validations');

/* Models */

define('MODELS', BACKEND . '/models');

/* Views */

define('VIEWS', BACKEND . '/views');
define('LANGS', VIEWS . '/langs');
define('DATA', VIEWS . '/data');
define('TEMPLATES', VIEWS . '/templates');
define('COMPONENTS', TEMPLATES . '/COMPONENTS');
define('FORMS', TEMPLATES . '/FORMS');
define('LAYOUTS', TEMPLATES . '/LAYOUTS');
define('SCREENS', TEMPLATES . '/SCREENS');

/* Others */

define('TPL_PLACEHOLDER_PATTERN', '{{::%s::}}');
