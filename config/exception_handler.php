<?php

declare(strict_types=1);

use App\Exception\Handler\HttpExceptionHandler;
use App\Exception\Handler\ValidationExceptionHandler;

return [
    HttpExceptionHandler::class,
    ValidationExceptionHandler::class,
];
