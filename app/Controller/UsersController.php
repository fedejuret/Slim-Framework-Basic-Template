<?php

namespace App\Controller;

use App\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Jgut\Slim\Routing\Mapping\Attribute\Route;
use App\Middleware\AuthorizationHeaderMiddleware;
use Jgut\Slim\Routing\Mapping\Attribute\Middleware;

class UsersController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route(pattern: '/users')]
    #[Middleware(AuthorizationHeaderMiddleware::class)]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        return $this->response($response, [
            'status' => 'works',
            'users' => $this->userService->all()
        ]);
    }
}