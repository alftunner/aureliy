<?php

use core\App;

if (PHP_MAJOR_VERSION < 8) {
    die("Необходима версия PHP >= 8");
}

require_once dirname(__DIR__) . '/config/init.php';

new \core\App();
var_dump(App::$app->getProperties());