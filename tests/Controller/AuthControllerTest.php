<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $this->client = static::createClient();
    }
    
    /**
     * User register fail test
     */
    public function testRegisterFail()
    {
        // Request a specific page
        $this->client->request('POST', '/register', [
            'username' => 'test',
        ]);
        
        // the HttpKernel response instance
        $response = $this->client->getResponse();
        
        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertEquals('{"errors":{"[password]":"This value should not be blank.","[email]":"This value should not be blank."}}', $response->getContent());
    }

    /**
     * User register success test
     */
    public function testRegisterSuccess()
    {
        $user = 'qa_test_' . time();
        // Request a specific page
        $this->client->request('POST', '/register', [
            'username' => $user,
            'password' => $user,
            'email' => $user . '@path.com',
        ]);
        
        // the HttpKernel response instance
        $response = $this->client->getResponse();
        
        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('{"success":"User ' . $user . ' successfully created"}', $response->getContent());
    }
}