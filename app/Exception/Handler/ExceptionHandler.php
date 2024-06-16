<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ExceptionHandler
{
    /**
     * Handle incoming exception.
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response, Throwable $exception): ResponseInterface;

    /**
     * Determinate if incoming exception will be handled by the handler.
     */
    public function mustHandle(Throwable $throwable): bool;

    /**
     * If incoming exception are handled, determinate if you should stop propagation of others handlers.
     */
    public function shouldStopPropagation(): bool;
}
