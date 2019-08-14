<?php
use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

return function (App $app) {
    $app->get('/products', function (ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write(json_encode(['setup' => 'success']));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
