<?php

use App\Handlers\GetProduct;
use App\Handlers\GetProductGroup;
use App\Handlers\GetProductGroups;
use App\Handlers\GetProducts;
use Slim\App;

return function (App $app) {
    $app->get('/products', GetProducts::class);
    $app->get('/products/{id}', GetProduct::class);

    $app->get('/product-groups', GetProductGroups::class);
    $app->get('/product-groups/{id}', GetProductGroup::class);
};
