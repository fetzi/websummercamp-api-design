<?php

namespace App\Handlers;

use App\Documents\ProductDocument;
use App\Models\Product;
use App\Resources\ProductResource;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WoohooLabs\Yin\JsonApi\JsonApi;

class GetProduct implements RequestHandlerInterface
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
        $id = $request->getAttribute('route')->getArgument('id');
        $product = Product::findOrFail($id);

        $document = new ProductDocument(new ProductResource);

        return $this->jsonApi->respond()->ok($document, $product);
    }
}