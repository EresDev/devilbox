<?php
/*
 * This file is part of the MyHammer RESTful API
 *
 * Arslan Afzal <arslanafzal321@gmail.com>
 *
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Service Entity Collection Test(s) for RESTful API
 */
class ServiceControllerTest extends WebTestCase
{
    /**
     * Response status code must be 200 HTTP OK
     * Must return one or more Services
     * Service table should never be empty
     */
    public function testGetAction(){

        $client = static::createClient();
        $client->request('GET', '/services');
        $response = $client->getResponse();

        //make sure the response was 200 HTTP OK
        $this->assertEquals(200, $response->getStatusCode());

        //deserialize the services
        $services  = json_decode($response->getContent());

        //The number of services are greater than zero
        $greaterThanZero = count($services) > 0;
        $this->assertTrue($greaterThanZero);

    }
}