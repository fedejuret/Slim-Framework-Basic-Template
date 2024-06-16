<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\ValidationException;

abstract class Controller
{
    /**
     * @throws \App\Exception\Exception\ValidationException
     */
    protected function validate(Request $request, array $rules): null|array|object
    {
        $data = $request->getQueryParams();
        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'])) {
            $data = json_decode($request->getBody()->getContents(), true);
        }

        $errors = [];

        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($data[$field] ?? null);
            } catch (ValidationException $exception) {
                $errors[$field] = $exception->getMessages();
            }
        }

        if (! empty($errors)) {
            throw new \App\Exception\Exception\ValidationException(json_encode($errors), 422);
        }

        return $data;
    }

    protected function response(ResponseInterface $response, ?array $data = null, int $statusCode = 200): ResponseInterface
    {
        $responseInterface = $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
        $responseInterface->getBody()->write(json_encode($data));
        return $responseInterface;
    }
}
