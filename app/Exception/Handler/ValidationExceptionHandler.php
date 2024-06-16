<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Exception\Exception\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

final class ValidationExceptionHandler implements ExceptionHandler
{
    /**
     * Handle incoming exception.
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response, Throwable $exception): ResponseInterface
    {
        $responseInterface = $response->withStatus(422)->withHeader('Content-Type', 'application/json');
        $responseInterface->getBody()->write(json_encode([
            'error' => json_decode($exception->getMessage(), true),
        ], JSON_UNESCAPED_UNICODE));

        return $responseInterface;
    }

    /**
     * Determinate if incoming exception will be handled by the handler.
     */
    public function mustHandle(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }

    /**
     * If incoming exception are handled, determinate if you should stop propagation of others handlers.
     */
    public function shouldStopPropagation(): bool
    {
        return true;
    }
}
