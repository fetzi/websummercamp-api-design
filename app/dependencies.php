<?php

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use App\JsonApi\DocumentFactory;
use Illuminate\Database\Capsule\Manager;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        DocumentFactory::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            return new DocumentFactory($settings['jsonapi']);
        },
        Manager::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $manager = new Manager();

            $manager->addConnection($settings['database'], 'default');
            $manager->setAsGlobal();
            $manager->bootEloquent();

            return $manager;
        },
    ]);
};
