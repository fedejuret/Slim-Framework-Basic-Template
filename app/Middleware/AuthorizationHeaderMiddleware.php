<?php

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Container\ContainerExceptionInterface;

class AuthorizationHeaderMiddleware implements MiddlewareInterface
{

    public function __construct(private ContainerInterface $container)
    {

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('Authorization')) {
            $response = $this->container->get(ResponseFactoryInterface::class)->createResponse();
            $response->getBody()->write(json_encode([
                'error' => 'please send Authorization header',
            ]));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
        return $handler->handle($request);
    }
}