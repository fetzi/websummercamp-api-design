<?php
declare(strict_types=1);

use App\Handlers\HttpErrorHandler;
use App\Middlewares\MakeJsonApiRequest;
use DI\Container;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use WoohooLabs\Yin\JsonApi\Exception\DefaultExceptionFactory;
use WoohooLabs\Yin\JsonApi\JsonApi;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequest;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__ . '/../');
$dotenv->load();

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
	$containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

$container->get(Manager::class);

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$exceptionFactory = new DefaultExceptionFactory;
$jsonApiRequest = new JsonApiRequest(ServerRequestFactory::createFromGlobals(), $exceptionFactory);

$container->set(JsonApi::class, new JsonApi(
	$jsonApiRequest,
	$responseFactory->createResponse()
));

// Register middleware
$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

/** @var bool $displayErrorDetails */
$displayErrorDetails = $container->get('settings')['displayErrorDetails'];

// Add Routing Middleware
$app->addRoutingMiddleware();

$app->add(new MakeJsonApiRequest());

$jsonApi = $container->get(JsonApi::class);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(new HttpErrorHandler($callableResolver, $responseFactory, $jsonApi));

$app->run();