<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use WoohooLabs\Yin\JsonApi\Exception\DefaultExceptionFactory;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequest;

class MakeJsonApiRequest
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $exceptionFactory = new DefaultExceptionFactory;
        $jsonApiRequest = new JsonApiRequest($request, $exceptionFactory);

        return $handler->handle($jsonApiRequest);
    }
}