<?php

function __autoload($class) {
    $filename = realpath(__DIR__ . "/" . str_replace("\\", "/", $class) . ".php");
    if (!empty($filename)) {
        require $filename;
    }
}

date_default_timezone_set("Indian/Antananarivo");
$application = new core\App();
$application->run();