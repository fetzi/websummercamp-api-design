<?php

namespace App\Handlers;

use App\JsonApi\DocumentFactory;
use HackerBoy\JsonApi\Document;
use HackerBoy\JsonApi\Elements\Error;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\CallableResolverInterface;

class HttpErrorHandler extends ErrorHandler
{
    /**
     * @var DocumentFactory
     */
    private $documentFactory;

    public function __construct(
        CallableResolverInterface $callableResolver,
        ResponseFactoryInterface $responseFactory,
        DocumentFactory $documentFactory
    ) {
        parent::__construct($callableResolver, $responseFactory);

        $this->documentFactory = $documentFactory;
    }

    protected function respond(): ResponseInterface
    {
        $document = $this->documentFactory->create();

        $error = new Error([
            'id' => uniqid(),
            'status' => $this->exception->getCode(),
            'code' => $this->exception->getCode(),
            'title' => $this->exception->getMessage(),
        ], $document);

        $document->setErrors($error);

        $response = $this->responseFactory->createResponse($this->exception->getCode())
            ->withHeader('Content-Type', 'application/vnd.api+json');
        $response->getBody()->write($document->toJson());

        return $response;
    }
}