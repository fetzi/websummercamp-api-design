<?php

namespace App\Hydrators;

use App\Models\ProductGroup;
use LogicException;
use WoohooLabs\Yin\JsonApi\Hydrator\Relationship\ToOneRelationship;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequestInterface;

class ProductHydrator extends BaseHydrator
{
    protected function getAcceptedTypes(): array
    {
        return ['product'];
    }

    protected function validateRequest(JsonApiRequestInterface $request): void
    {
        $price = intval($request->getResourceAttribute('price', 0));

        if ($price <= 0) {
            throw new LogicException('The price must be greater than 0!', 400);
        }
    }

    protected function getAttributeHydrator($object): array
    {
        return [
            'name' => function ($object, $value) {
                $object->name = $value;
            },
            'price' => function ($object, $value) {
                $object->price = $value;
            },
        ];
    }

    protected function getRelationshipHydrator($resource): array
    {
        return [
            'product-group' => function ($object, ToOneRelationship $relationship) {
                $productGroup = ProductGroup::find($relationship->getResourceIdentifier()->getId());
                $object->productGroup()->associate($productGroup);
            },
        ];
    }
}