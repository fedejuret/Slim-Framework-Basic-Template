<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\Exception\ValidationException;
use Jgut\Slim\Routing\Mapping\Attribute\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;

final class GreetingsController extends Controller
{
    /**
     * @throws ValidationException
     */
    #[Route(methods: ['GET', 'POST'], pattern: '/greeting/{name}')]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $this->validate($request, [
            'name' => Validator::stringType()->length(5, 10),
        ]);

        return $this->response($response, [
            'status' => 'Hi, ' . $args['name'],
        ]);
    }
}
