<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Level;

return [
    'default' => env('LOGGING_DEFAULT', 'file'),

    'channels' => [
        'file' => [
            'handler' => StreamHandler::class,
            'params' => [
                'stream' => __DIR__ . '/../logs/app.log',
                'level' => Level::Debug,
            ],
        ],
    ],
];
