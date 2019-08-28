<?php

namespace App\Middlewares;

use App\Exceptions\NotAuthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class APITokenMiddleware implements MiddlewareInterface
{
    const VALID_TOKEN = 'token';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $apiToken = $request->getHeaderLine('X-API-Token');

        if ($apiToken !== static::VALID_TOKEN) {
            throw new NotAuthorizedException();
        }

        return $handler->handle($request->withAttribute('api-token', $apiToken));
    }
}