<?php

use App\Handlers\CreateProduct;
use App\Handlers\GetProduct;
use App\Handlers\GetProductGroup;
use App\Handlers\GetProductGroups;
use App\Handlers\GetProducts;
use App\Handlers\UpdateProduct;
use Slim\App;

return function (App $app) {
    $app->get('/products', GetProducts::class);
    $app->get('/products/{id}', GetProduct::class);

    $app->post('/products', CreateProduct::class);
    $app->patch('/products/{id}', UpdateProduct::class);

    $app->get('/product-groups', GetProductGroups::class);
    $app->get('/product-groups/{id}', GetProductGroup::class);
};
