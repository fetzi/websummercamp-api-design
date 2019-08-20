<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\CallableResolverInterface;
use WoohooLabs\Yin\JsonApi\JsonApi;
use WoohooLabs\Yin\JsonApi\Schema\Document\ErrorDocument;
use WoohooLabs\Yin\JsonApi\Schema\Error\Error;

class HttpErrorHandler extends ErrorHandler
{
    /**
     * @var JsonApi
     */
    private $jsonApi;

    public function __construct(
        CallableResolverInterface $callableResolver,
        ResponseFactoryInterface $responseFactory,
        JsonApi $jsonApi
    ) {
        parent::__construct($callableResolver, $responseFactory);

        $this->jsonApi = $jsonApi;
    }

    protected function respond(): ResponseInterface
    {
        $code = $this->exception->getCode();

        if ($code === 0) {
            $code = 500;
        }

        $error = Error::create()
            ->setCode($code)
            ->setStatus($code)
            ->setTitle($this->exception->getMessage());

        return $this->jsonApi->respond()->genericError(new ErrorDocument([$error]));
    }
}