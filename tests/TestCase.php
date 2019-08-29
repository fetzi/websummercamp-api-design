<?php
declare(strict_types=1);

namespace Tests;

use App\Handlers\HttpErrorHandler;
use App\Middlewares\MakeJsonApiRequest;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Exception;
use Illuminate\Database\Capsule\Manager;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\StreamInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Stream;
use Slim\Psr7\Uri;
use WoohooLabs\Yin\JsonApi\Exception\DefaultExceptionFactory;
use WoohooLabs\Yin\JsonApi\JsonApi;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequest;

class TestCase extends PHPUnit_TestCase
{
    protected function setUp()
    {
        exec('php setup/migrations.php && php setup/seeds.php');
    }

    /**
     * @return App
     * @throws Exception
     */
    protected function getAppInstance(): App
    {
        $dotenv = Dotenv::create(__DIR__ . '/../');
        $dotenv->load();

        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        // Container intentionally not compiled for tests.

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


        // Add Routing Middleware
        $app->addRoutingMiddleware();

        $app->add(new MakeJsonApiRequest());

        $jsonApi = $container->get(JsonApi::class);

        $errorMiddleware = $app->addErrorMiddleware(false, false, false);
        $errorMiddleware->setDefaultErrorHandler(new HttpErrorHandler($callableResolver, $responseFactory, $jsonApi));

        return $app;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $headers
     * @param array  $serverParams
     * @param array  $cookies
     * @return Request
     */
    protected function createRequest(
        string $method,
        string $path,
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $serverParams = [],
        array $cookies = []
    ): Request {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        return new SlimRequest($method, $uri, $h, $serverParams, $cookies, $stream);
    }

    public function assertJsonBodyEquals(string $expectedFile, ResponseInterface $response)
    {
        $expected = json_decode(file_get_contents($expectedFile), true);

        $response->getBody()->rewind();
        $actual = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals($expected, $actual);
    }

    protected function createStream($filePath) : StreamInterface
    {
        return new Stream(fopen($filePath, 'r'));
    }
}
