<?php

use DI\ContainerBuilder;
use Monolog\Logger;
use App\Models\Product;
use App\JsonApi\Resources\ProductResource;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'jsonapi' => [
                'resource_map' => [
                    Product::class => ProductResource::class,
                ],
                'api_url' => 'http://localhost:8080',
                'auto_set_links' => true,
            ],
            'database' => [
                'driver'   => getenv('DB_DRIVER'),
                'database' => __DIR__ . getenv('DB_DATABASE'),
                'prefix'   => '',
            ]
        ],
    ]);
};
