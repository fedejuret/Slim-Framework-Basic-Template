<?php

declare(strict_types=1);

namespace App\Controller;

use Jgut\Slim\Routing\Mapping\Attribute\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
