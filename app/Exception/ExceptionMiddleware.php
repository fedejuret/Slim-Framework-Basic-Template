<?php

declare(strict_types=1);

namespace App\Exception;

use App\Exception\Handler\ExceptionHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use Slim\Psr7\Response;
use Throwable;

final readonly class ExceptionMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(private array $handlers, private ContainerInterface $container)
    {
        $this->logger = $this->container->get(LoggerInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage(), ['exception' => $exception]);

            if (empty($this->handlers)) {
                return $this->fallBack($exception);
            }

            foreach ($this->handlers as $handler) {
                $reflection = new ReflectionClass($handler);
                if (! $reflection->implementsInterface(ExceptionHandler::class)) {
                    continue;
                }
                /** @var ExceptionHandler $class */
                $class = new $handler();
                if ($class->mustHandle($exception)) {
                    $response = $class->handle($request, new Response(), $exception);
                    if ($class->shouldStopPropagation()) {
                        return $response;
                    }
                }
            }

            return $this->fallBack($exception);
        }
    }

    private function fallBack(Throwable $throwable): Response|ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write('An error occurred: ' . $throwable->getMessage());
        return $response->withStatus(500);
    }
}
