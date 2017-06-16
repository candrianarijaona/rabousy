<?php
/**
 * Global app settings
 */
return [
    'base_url' => 'http://localhost:8888',
    'namespace' => 'Rabousy',
    'debug' => true, //Set this param to false in production
    'time_zone' => "Indian/Antananarivo",
    'controller' => [
        'default' => 'Index',
        'path' => 'Controllers',
        'default_action' => 'index',
    ],
    'view' => [
        'path' => __DIR__ . '/Rabousy/views',
        'layout' => 'layouts',
        'default' => 'default',
    ]
];
