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

    public function testCreateProduct()
    {
        $stream = $this->createStream(__DIR__ . '/requests/create_product.json');
        $request = $this->createRequest('POST', '/products', ['X-API-Token' => 'token'])
            ->withBody($stream);

        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJsonBodyEquals(__DIR__ . '/expectations/created_product.json', $response);
    }

    public function testCreateProductWithZeroPrice()
    {
        $stream = $this->createStream(__DIR__ . '/requests/create_product_invalid_price.json');
        $request = $this->createRequest('POST', '/products', ['X-API-Token' => 'token'])
            ->withBody($stream);

        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testUpdateProduct()
    {
        $stream = $this->createStream(__DIR__ . '/requests/update_product.json');
        $request = $this->createRequest('PATCH', '/products/1', ['X-API-Token' => 'token'])
            ->withBody($stream);

        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonBodyEquals(__DIR__ . '/expectations/updated_product.json', $response);
    }
}