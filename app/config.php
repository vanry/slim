<?php

return [
    'app' => [
        'name' => 'Slim',
        'debug' => true,
        'timezone' => 'UTC',
    ],

    'logger' => [
        'name' => 'slim',
        'path' => storage_path('logs/slim.log'),
        'level' => Monolog\Logger::DEBUG,
        'max_files' => 30,
        'date_format' => 'Y-m-d H:i:s',
    ],

    'view' => [
        'path' => resource_path('views'),
        'layout' => null,
    ],
];
