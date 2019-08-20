<?php

namespace App\Resources;

use WoohooLabs\Yin\JsonApi\Schema\Link\ResourceLinks;
use WoohooLabs\Yin\JsonApi\Schema\Resource\AbstractResource;

abstract class BaseResource extends AbstractResource
{
    /**
     * @inheritdoc
     */
    public abstract function getType($object): string;

    /**
     * @inheritdoc
     */
    public abstract function getId($object): string;

    /**
     * @inheritdoc
     */
    public function getAttributes($object): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getMeta($object): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getLinks($object): ?ResourceLinks
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultIncludedRelationships($object): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getRelationships($object): array
    {
        return [];
    }
}