<?php

define('ROOT', dirname(__DIR__, 2) . '');

/* Public */

define('FRONTEND', ROOT . '/public');

/* Server */

define('BACKEND', ROOT . '/app/');
define('TEMPLATES', BACKEND . '/view/templates');
define('COMPONENTS', TEMPLATES . '/components');
define('SCREENS', TEMPLATES . '/screens');
define('GLOBALS', TEMPLATES . '/globals');
define('FORMS', TEMPLATES . '/forms');

/* Others */

define('TPL_PLACEHOLDER_PATTERN', '{{::%s::}}');
