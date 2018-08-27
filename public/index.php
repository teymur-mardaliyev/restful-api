<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();


// Set up dependencies
$container = require __DIR__ . '/../src/config/dependencies.php';
// Instantiate the app
$app = new \Slim\App($container);

// Register middleware
require __DIR__ . '/../src/config/middleware.php';

// Register routes
require __DIR__ . '/../src/config/routes.php';

// Run app
$app->run();
