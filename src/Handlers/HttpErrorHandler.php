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
    private $validStatusCodes = ["100","101","200","201","202","203","204","205","206","300","301","302","303","304","305","306","307","400","401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","416","417","500","501","502","503","504","505"];

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

        if (!in_array($code, $this->validStatusCodes)) {
            $code = 500;
        }

        $error = Error::create()
            ->setCode($code)
            ->setStatus($code)
            ->setTitle($this->exception->getMessage());

        return $this->jsonApi->respond()->genericError(new ErrorDocument([$error]));
    }
}