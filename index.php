<?php

// Define application roots
define('ROOT', dirname(__FILE__));
define('APP_ROOT', ROOT . '/application/');
define('SYS_ROOT', ROOT . '/system/');

// Include config
require APP_ROOT . 'config.php';

// Run application
require SYS_ROOT . 'app.php';
$app = new Application();
$app->run();