<?php

namespace App\Resources;

class ProductGroupResource extends BaseResource
{
    public function getType($object): string
    {
        return 'product-group';
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
        ];
    }
}