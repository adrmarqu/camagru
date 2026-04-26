<?php

define('ROOT', dirname(__DIR__, 2) . '/');

/* Public */

define('FRONTEND', ROOT . 'public/');

/* Server */

define('BACKEND', ROOT . 'app/');
define('COMPONENTS', BACKEND . 'view/templates/components/');

/* Others */

define('TPL_PLACEHOLDER_PATTERN', '{{::%s::}}');
