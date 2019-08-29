<?php

namespace Tests;

class ProductTest extends TestCase
{
    public function testGetProducts()
    {
        $request = $this->createRequest('GET', '/products', ['X-API-Token' => 'token']);
        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonBodyEquals(__DIR__ . '/expectations/products.json', $response);
    }

    public function testGetOneProduct()
    {
        $request = $this->createRequest('GET', '/products/1', ['X-API-Token' => 'token']);
        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonBodyEquals(__DIR__ . '/expectations/product.json', $response);
    }

    public function testGetInvalidProductId()
    {
        $request = $this->createRequest('GET', '/products/100', ['X-API-Token' => 'token']);
        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(404, $response->getStatusCode());
    }
}