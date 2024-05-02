<?php

declare(strict_types=1);

namespace Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private static ?KernelBrowser $baseClient = null;

    public function setUp(): void
    {
        parent::setUp();

        if (!self::$baseClient) {
            self::$baseClient = static::createClient();
            self::$baseClient->setServerParameters([
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ]);
        }
    }

    public function testCreateProductActionWithValidParams()
    {
        self::$baseClient->setServerParameter('HTTP_Authorization', 'Bearer admintoken');
        
        $jsonData = [
            'name' => 'Abanico',
            'description' => 'Para abanicarse',
            'price' => 0.99,
            'tax_id' => 3,
        ];

        self::$baseClient->request(
            Request::METHOD_POST,
            '/api/products',
            [],
            [],
            [], 
            json_encode($jsonData)
        );

        $response = self::$baseClient->getResponse();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());

        self::$baseClient->setServerParameter('HTTP_Authorization', '');
    }

    public function testGetProductsActionWithValidParams()
    {
        
        self::$baseClient->request(Request::METHOD_GET, '/api/products?name=Abanic');
        $response = self::$baseClient->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertIsArray($responseData);
        $numResults = count($responseData);

        $this->assertGreaterThan(0, $numResults, 'Expected at least one result');
    }

    public function testGetProductsActionWithSpecificParams()
    {
        
        self::$baseClient->request(Request::METHOD_GET, '/api/products?name=Abanic');
        $response = self::$baseClient->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $responseData = json_decode($response->getContent(), true);
        $this->assertIsArray($responseData);
        $numResults = count($responseData);

        $this->assertEquals(1, $numResults, 'Expected at least one result');
    }

    public function testGetProductsActionWithoutParams()
    {
        
        self::$baseClient->request(Request::METHOD_GET, '/api/products');
        $response = self::$baseClient->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }    

    public function testCreateProductActionWithInvalidParams()
    {
        
        self::$baseClient->request(Request::METHOD_POST, '/api/products', [], [], [], json_encode([
            'invalidParam' => 'value',
        ]));
        $response = self::$baseClient->getResponse();

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    
}
