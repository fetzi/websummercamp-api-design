<?php

namespace App\Handlers;

use App\Documents\ProductDocument;
use App\Hydrators\ProductHydrator;
use App\Models\Product;
use App\Resources\ProductResource;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WoohooLabs\Yin\JsonApi\Exception\DefaultExceptionFactory;
use WoohooLabs\Yin\JsonApi\JsonApi;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequest;

class CreateProduct implements RequestHandlerInterface
{
    /**
     * @var JsonApi
     */
    private $jsonApi;

    public function __construct(JsonApi $jsonApi)
    {
        $this->jsonApi = $jsonApi;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->jsonApi->setRequest(new JsonApiRequest($request, new DefaultExceptionFactory));
        $product = $this->jsonApi->hydrate(new ProductHydrator, new Product());
        $product->save();

        $document = new ProductDocument(new ProductResource);

        return $this->jsonApi->respond()->created($document, $product);
    }
}