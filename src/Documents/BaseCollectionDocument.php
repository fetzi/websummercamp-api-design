<?php

namespace App\Documents;

use WoohooLabs\Yin\JsonApi\Schema\Document\AbstractCollectionDocument;
use WoohooLabs\Yin\JsonApi\Schema\JsonApiObject;
use WoohooLabs\Yin\JsonApi\Schema\Link\DocumentLinks;

class BaseCollectionDocument extends AbstractCollectionDocument
{
    public function getJsonApi(): ?JsonApiObject
    {
        return new JsonApiObject("1.1");
    }

    public function getLinks(): ?DocumentLinks
    {
        return null;
    }

    public function getMeta(): array
    {
        return [];
    }
}