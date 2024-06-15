<?php

namespace App\Exception\Handler;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ExceptionHandler
{
    /**
     * Handle incoming exception
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Throwable $exception
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, ResponseInterface $response, Throwable $exception): ResponseInterface;

    /**
     * Determinate if incoming exception will be handled by the handler
     *
     * @param Throwable $throwable
     * @return bool
     */
    public function mustHandle(\Throwable $throwable): bool;

    /**
     * If incoming exception are handled, determinate if you should stop propagation of others handlers
     *
     * @return bool
     */
    public function shouldStopPropagation(): bool;
}