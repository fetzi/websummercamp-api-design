<?php

use App\Middlewares\APITokenMiddleware;
use App\Middlewares\ModelNotFoundMiddleware;
use App\Middlewares\RequestLoggerMiddleware;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    $app->addMiddleware($container->get(RequestLoggerMiddleware::class));

    $app->addMiddleware($container->get(APITokenMiddleware::class));
    $app->addMiddleware($container->get(ModelNotFoundMiddleware::class));
};
