<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Jgut\Slim\Routing\Mapping\Attribute\Route;

class IndexController extends Controller
{
    #[Route(pattern: '/')]
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->response([
            'status' => 'works',
        ], 200);
    }
}