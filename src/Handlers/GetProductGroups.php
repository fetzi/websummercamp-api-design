<?php

namespace App\Handlers;

use App\Documents\ProductGroupsDocument;
use App\Models\ProductGroup;
use App\Resources\ProductGroupResource;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WoohooLabs\Yin\JsonApi\JsonApi;

class GetProductGroups implements RequestHandlerInterface
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
        $productGroups = ProductGroup::get();

        $productGroupsDocument = new ProductGroupsDocument(new ProductGroupResource);

        return $this->jsonApi->respond()->ok($productGroupsDocument, $productGroups);
    }
}