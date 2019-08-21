<?php

namespace App\Hydrators;

use WoohooLabs\Yin\JsonApi\Exception\ExceptionFactoryInterface;
use WoohooLabs\Yin\JsonApi\Hydrator\AbstractHydrator;
use WoohooLabs\Yin\JsonApi\Request\JsonApiRequestInterface;

abstract class BaseHydrator extends AbstractHydrator
{
    /**
     * @inheritdoc
     */
    protected function getRelationshipHydrator($book): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    protected function validateClientGeneratedId(
        string $clientGeneratedId,
        JsonApiRequestInterface $request,
        ExceptionFactoryInterface $exceptionFactory
    ): void {
    }

    /**
     * @inheritdoc
     */
    protected function generateId(): string
    {
        return uniqid();
    }

    /**
     * @inheritdoc
     */
    protected function setId($resource, string $id)
    {
        return $resource;
    }

    /**
     * @inheritdoc
     */
    protected function validateRequest(JsonApiRequestInterface $request): void
    {
    }


}