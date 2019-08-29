<?php

namespace App\Resources;

use WoohooLabs\Yin\JsonApi\Schema\Relationship\ToOneRelationship;

class ProductResource extends BaseResource
{
    public function getType($object): string
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function getId($object): string
    {
        return $object->id;
    }

    public function getAttributes($object): array
    {
        return [
            'name' => function ($object) {
                return $object->name;
            },
            'price' => function ($object) {
                return intval($object->price);
            },
        ];
    }

    public function getRelationships($object): array
    {
        return [
            'product-group' => function ($object) {
                return ToOneRelationship::create()
                    ->setData($object->productGroup, new ProductGroupResource);
            }
        ];
    }
}