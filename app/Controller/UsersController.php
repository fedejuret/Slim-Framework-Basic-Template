<?php

declare(strict_types=1);

namespace App\Controller;

use App\Middleware\AuthorizationHeaderMiddleware;
use App\Service\UserService;
use Jgut\Slim\Routing\Mapping\Attribute\Middleware;
use Jgut\Slim\Routing\Mapping\Attribute\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsersController extends Controller
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
            'users' => $this->userService->all(),
        ]);
    }
}
