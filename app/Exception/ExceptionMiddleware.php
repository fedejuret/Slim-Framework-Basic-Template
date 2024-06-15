<?php

namespace App\Exception;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Exception\Handler\ExceptionHandler;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionClass;

final readonly class ExceptionMiddleware implements MiddlewareInterface
{
    public function __construct(private array $handlers)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {

            if (empty($this->handlers)) {
                return $this->fallBack($exception);
            }

            foreach ($this->handlers as $handler) {
                $reflection = new ReflectionClass($handler);
                if (!$reflection->implementsInterface(ExceptionHandler::class)) {
                    continue;
                }
                /** @var ExceptionHandler $class */
                $class = new $handler;
                if ($class->mustHandle($exception)) {
                    $response = $class->handle($request, new \Slim\Psr7\Response(), $exception);
                    if ($class->shouldStopPropagation()) {
                        return $response;
                    }
                }
            }

            return $this->fallBack($exception);
        }
    }

    private function fallBack(\Throwable $throwable): \Slim\Psr7\Response|ResponseInterface
    {
        $response = new \Slim\Psr7\Response();
        $response->getBody()->write('An error occurred: ' . $throwable->getMessage());
        return $response->withStatus(500);
    }
}