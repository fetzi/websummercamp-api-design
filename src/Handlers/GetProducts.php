<?php

namespace App\Handlers;

use App\Documents\ProductsDocument;
use App\Models\Product;
use App\Resources\ProductResource;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WoohooLabs\Yin\JsonApi\JsonApi;

class GetProducts implements RequestHandlerInterface
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
        $products = Product::get();

        $document = new ProductsDocument(new ProductResource);

        return $this->jsonApi->respond()->ok($document, $products);
    }
}