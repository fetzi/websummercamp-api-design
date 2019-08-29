<?php

namespace Tests;

class ProductGroupTest extends TestCase
{
    public function testGetAllProductGroups()
    {
        $request = $this->createRequest('GET', '/product-groups', ['X-API-Token' => 'token']);
        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonBodyEquals(__DIR__ . '/expectations/product_groups.json', $response);
    }

    public function testGetOneProductGroup()
    {
        $request = $this->createRequest('GET', '/product-groups/1', ['X-API-Token' => 'token']);
        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonBodyEquals(__DIR__ . '/expectations/product_group.json', $response);
    }

    public function testInvalidProductGroupId()
    {
        $request = $this->createRequest('GET', '/product-groups/100', ['X-API-Token' => 'token']);
        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }
}