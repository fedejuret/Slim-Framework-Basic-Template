<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Jgut\Slim\Routing\Mapping\Attribute\Route;
use App\Middleware\AuthorizationHeaderMiddleware;
use Jgut\Slim\Routing\Mapping\Attribute\Middleware;

class GreetingsController extends Controller
{

    #[Route(pattern: '/greeting/{name}')]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        return $this->response($response, [
            'status' => 'Hi, ' . $args['name'],
        ]);
    }
}