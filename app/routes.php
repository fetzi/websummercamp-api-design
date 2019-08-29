<?php

use App\Handlers\GetProductGroup;
use App\Handlers\GetProductGroups;
use App\Models\Product;
use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

return function (App $app) {
    $app->get('/products', function (ServerRequestInterface $request, ResponseInterface $response) {
        $product = Product::find(1);

        $response->getBody()->write(json_encode($product));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/product-groups', GetProductGroups::class);
    $app->get('/product-groups/{id}', GetProductGroup::class);
};
