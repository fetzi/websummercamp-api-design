<?php

namespace App\JsonApi;

use HackerBoy\JsonApi\Document;

class DocumentFactory
{
    /**
     * @var array
     */
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function create() : Document
    {
        return new Document($this->config);
    }
}