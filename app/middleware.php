<?php

use App\Middlewares\APITokenMiddleware;
use App\Middlewares\RequestLoggerMiddleware;
use Slim\App;

return function (App $app) {
    $requestLoggerMiddleware = $app->getContainer()->get(RequestLoggerMiddleware::class);
    $app->addMiddleware($requestLoggerMiddleware);

    $app->addMiddleware($app->getContainer()->get(APITokenMiddleware::class));
};
