<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Jgut\Slim\Routing\Mapping\Attribute\Route;

class IndexController extends Controller
{

    #[Route(pattern: '/fede')]
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $this->response->getBody()->write(json_encode(['some' => 'yes']));
        return $this->response;
    }
}