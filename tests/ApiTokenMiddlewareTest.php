<?php

namespace Tests;

class ApiTokenMiddlewareTest extends TestCase
{
    public function testInvalidApiTokenGetsHandled()
    {
        $request = $this->createRequest('GET', '/products');

        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(401, $response->getStatusCode());

        $this->assertJsonBodyEquals(__DIR__ . '/expectations/invalid_token.json', $response);
    }

    public function testWithValidApiToken()
    {
        $request = $this->createRequest('GET', '/products')->withHeader('X-API-Token', 'token');
        $response = $this->getAppInstance()->handle($request);

        $this->assertEquals(200, $response->getStatusCode());
    }
}