<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpException as SlimHttpException;
use Throwable;

final class HttpExceptionHandler implements ExceptionHandler
{
    /**
     * Handle incoming exception.
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response, Throwable $exception): ResponseInterface
    {
        $responseInterface = $response->withStatus($exception->getCode());
        $responseInterface->getBody()->write($exception->getMessage());

        return $responseInterface;
    }

    /**
     * Determinate if incoming exception will be handled by the handler.
     */
    public function mustHandle(Throwable $throwable): bool
    {
        return $throwable instanceof SlimHttpException;
    }

    /**
     * If incoming exception are handled, determinate if you should stop propagation of others handlers.
     */
    public function shouldStopPropagation(): bool
    {
        return true;
    }
}
