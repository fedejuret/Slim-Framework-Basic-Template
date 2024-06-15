<?php

namespace App\Exception\Handler;

use Throwable;
use Slim\Exception\HttpException as SlimHttpException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class HttpExceptionHandler implements ExceptionHandler
{
    /**
     * Handle incoming exception
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Throwable $exception
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response, Throwable $exception): ResponseInterface
    {
        $responseInterface = $response->withStatus($exception->getCode());
        $responseInterface->getBody()->write($exception->getMessage());

        return $responseInterface;
    }

    /**
     * Determinate if incoming exception will be handled by the handler
     *
     * @param Throwable $throwable
     * @return bool
     */
    public function mustHandle(\Throwable $throwable): bool
    {
        return $throwable instanceof SlimHttpException;
    }

    /**
     * If incoming exception are handled, determinate if you should stop propagation of others handlers
     *
     * @return bool
     */
    public function shouldStopPropagation(): bool
    {
        return true;
    }
}