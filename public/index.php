<?php

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

// Instantiate the app
$configs = require __DIR__ . '/../app/config.php';

if ($configs['debug']) {
    error_reporting(E_ERROR); //active the error_reporting in dev mode
}

date_default_timezone_set($configs['time_zone']);

require __DIR__ . '/../vendor/autoload.php';


$application = new \Core\App($configs);
$application->run();
