<?php

namespace App\Controllers;

use App\Services\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Jgut\Slim\Routing\Mapping\Attribute\Route;
use Psr\Http\Message\ResponseFactoryInterface;

class UsersController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route(pattern: '/users')]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        return $this->response($response, [
            'status' => 'works',
            'users' => $this->userService->all()
        ], 200);
    }
}