<?php

namespace App\Documents;

use WoohooLabs\Yin\JsonApi\Schema\Document\AbstractSingleResourceDocument;
use WoohooLabs\Yin\JsonApi\Schema\JsonApiObject;
use WoohooLabs\Yin\JsonApi\Schema\Link\DocumentLinks;

class BaseDocument extends AbstractSingleResourceDocument
{
    public function getJsonApi(): ?JsonApiObject
    {
        return new JsonApiObject("1.1");
    }

    public function getMeta(): array
    {
        return [];
    }

    public function getLinks(): ?DocumentLinks
    {
        return null;
    }
}