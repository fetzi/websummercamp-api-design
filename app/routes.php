<?php
use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

return function (App $app) {
    $app->get('/products', function (ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write('Hello World!');
        return $response->withStatus(200);
    });
};
