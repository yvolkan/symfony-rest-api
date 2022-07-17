<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class OrderControllerTest extends WebTestCase
{   
    private $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }
    
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'path', $password = 'path')
    {
        $this->client->request(
        'POST',
        '/api/login_check',
        [],
        [],
        ['CONTENT_TYPE' => 'application/json'],
        json_encode([
            'username' => $username,
            'password' => $password,
        ])
        );

        $data = json_decode($this->client->getResponse()->getContent(), true);

        $this->client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $this->client;
    }

    /**
     * Unauthorized test
     *
     * @return void
     */
    public function getOrdersWithoutAuth()
    {
        // Request a specific page
        $this->client->request('GET', '/api/orders');
        
        // the HttpKernel response instance
        $response = $this->client->getResponse();
        
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }
    
    /**
     * Get Order Test
     */
    public function testGetOrder()
    {
        $this->createAuthenticatedClient();
        
        // Request a specific page
        $this->client->request('GET', '/api/orders/2');
        
        // the HttpKernel response instance
        $response = $this->client->getResponse();
        
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
    
    /**
     * Get Orders Test
     */
    public function testGetOrders()
    {
        $this->createAuthenticatedClient();
        
        // Request a specific page
        $this->client->request('GET', '/api/orders');
        
        // the HttpKernel response instance
        $response = $this->client->getResponse();
        
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}