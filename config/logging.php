<?php

return [
    'default' => env('LOGGING_DEFAULT', 'file'),

    'channels' => [
        'file' => [
            'handler' => \Monolog\Handler\StreamHandler::class,
            'params' => [
                'stream' => __DIR__ . '/../logs/app.log',
                'level' => \Monolog\Level::Debug,
            ],
        ],
    ]
];
