<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Jgut\Slim\Routing\Mapping\Attribute\Route;

final class GreetingsController extends Controller
{

    #[Route(pattern: '/greeting/{name}')]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        return $this->response($response, [
            'status' => 'Hi, ' . $args['name'],
        ]);
    }
}