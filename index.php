<?php

// Define application roots
define('ROOT', dirname(__FILE__));
define('APP_ROOT', ROOT . '/application/');

// Include config
require APP_ROOT . 'config.php';

// Run application
require ROOT . '/application/app.php';
$app = new Application();
$app->run();