<?php

namespace App\Handlers;

use App\Documents\ProductGroupDocument;
use App\Models\ProductGroup;
use App\Resources\ProductGroupResource;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\Route;
use WoohooLabs\Yin\JsonApi\JsonApi;

class GetProductGroup implements RequestHandlerInterface
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
        /** @var Route $route */
        $route = $request->getAttribute('route');
        $id = $route->getArgument('id');

        $productGroup = ProductGroup::findOrFail($id);

        $document = new ProductGroupDocument(new ProductGroupResource);

        return $this->jsonApi->respond()->ok($document, $productGroup);
    }
}