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
 * Job Entity Test(s) for RESTful API
 */
class JobControllerTest extends WebTestCase
{
    /**
     * Keep a record of all valid data attributes to be used by methods
     */
    private $valid_job_data = array(
        "title" => "A sample job title",
        "description" => "Sample job description",
        "zip" => "10115",
        "city" => "Berlin",
        "service_id" => 2,
        "action_datetime" => "2050-11-11 10:02:22",
    );

    /**
     * Response status code must be 200 HTTP OK
     * Must return one or more Services
     * Service table should never be empty
     */
    public function testGetAction()
    {
        //let's fetch job with ID=1
        $job_id = 1;

        //get the browser
        $client = static::createClient();

        //make the GET request
        $client->request('GET', '/job/'.$job_id );

        $response = $client->getResponse();

        //make sure the response was 200 HTTP OK
        $this->assertEquals(200, $response->getStatusCode());

        //deserialize the services
        $job  = json_decode($response->getContent());

        //Job with ID=1 returned
        $this->assertEquals(1, $job->id);
    }

    /**
    * Test adding a new Job, POST REQUEST
     * Test for valid data submission response
     * Test for invalid data submission response
    */
    public function testPostAction()
    {
        //make all valid data array
        $job_data = $this->getValidJobData();

        /**
         * ALL VALID DATA TEST
         */
        //Get the browser client
        $client = static::createClient();

        //make the post request with all valid data
        $client->request('POST', '/job' , $job_data);

        //make sure the response was 200 HTTP OK
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        /*
         * INVALID TITLE TEST
         */
        //make the title invalid, which is empty string
        $job_data["title"] = "";

        //make the post request with empty title
        $client->request('POST', '/job' , $job_data);

        //make sure the response was 406 HTTP NOT ACCEPTABLE
        $this->assertEquals(406, $client->getResponse()->getStatusCode());


        /*
         * INVALID ZIP CODE TEST
         */
        //make the title invalid, which is empty string
        $job_data["zip"] = "1321656511212";

        //make the post request
        $client->request('POST', '/job' , $job_data);

        //make sure the response was 406 HTTP NOT ACCEPTABLE
        $this->assertEquals(406, $client->getResponse()->getStatusCode());

        /*
         * INVALID ACTION DATETIME TEST
         */
        //make the date invalid, which date in past
        $job_data["action_datetime"] = "2017-11-11 12:02:02";

        //make the post request
        $client->request('POST', '/job' , $job_data);

        //make sure the response was 406 HTTP NOT ACCEPTABLE
        $this->assertEquals(406, $client->getResponse()->getStatusCode());

        /*
         * INVALID SERVICE TEST
         */
        //make the service invalid, service with ID=-1 will never exist
        $job_data["service_id"] = -1;

        //make the post request
        $client->request('POST', '/job' , $job_data);

        //make sure the response was 406 HTTP NOT ACCEPTABLE
        $this->assertEquals(406, $client->getResponse()->getStatusCode());
    }

    /**
     * Test updating a Job, PUT REQUEST
     * Test updating with valid data
     * Test updating with invalid data
     */
    public function testPutAction()
    {
        //make all valid data array
        $job_data = $this->getValidJobData();

        /**
         * ALL VALID DATA TEST
         * First, add a new job to be updated later so that the database maintains its state
         */
        //Get the browser client
        $client = static::createClient();

        //make the post request with all valid data
        $client->request('POST', '/job' , $job_data);

        //make sure the response was 200 HTTP OK
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $new_job_id = json_decode(
            $client->getResponse()->getContent()
        )
            ->job_id;

        /*
         * VALID DATA UPDATE TEST
         */
        //make the post request with all valid data
        $client->request('PUT', '/job/'.$new_job_id , $job_data);

        //make sure the response was 200 HTTP OK
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        /*
         * INVALID TITLE UPDATE TEST
         */
        //make the title invalid, which is empty string
        $job_data["title"] = "";

        //make the post request with empty title
        $client->request('PUT', '/job/'.$new_job_id , $job_data);

        //make sure the response was 406 HTTP NOT ACCEPTABLE
        $this->assertEquals(406, $client->getResponse()->getStatusCode());


        /*
         * INVALID ZIP CODE TEST
         */
        //make the title invalid, which is empty string
        $job_data["zip"] = "1321656511212";

        //make the post request
        $client->request('PUT', '/job/'.$new_job_id , $job_data);

        //make sure the response was 406 HTTP NOT ACCEPTABLE
        $this->assertEquals(406, $client->getResponse()->getStatusCode());

        /*
         * INVALID ACTION DATETIME TEST
         */
        //make the date invalid, which date in past
        $job_data["action_datetime"] = "2017-11-11 12:02:02";

        //make the post request
        $client->request('PUT', '/job/'.$new_job_id , $job_data);

        //make sure the response was 406 HTTP NOT ACCEPTABLE
        $this->assertEquals(406, $client->getResponse()->getStatusCode());

        /*
         * INVALID SERVICE TEST
         */
        //make the service invalid, service with ID=-1 will never exist
        $job_data["service_id"] = -1;

        //make the post request
        $client->request('PUT', '/job/'.$new_job_id , $job_data);

        //make sure the response was 406 HTTP NOT ACCEPTABLE
        $this->assertEquals(406, $client->getResponse()->getStatusCode());
    }

    /**
     * Test deleting a Job, DELETE REQUEST
     * Test deleting with valid JOB ID
     * Test deleting with invalid JOB ID
     */
    public function testDeleteAction()
    {
        /**
         * Insert a new Job first to be tested for deletion
         */
        //make all valid data array
        $job_data = $this->getValidJobData();

        //Get the browser client
        $client = static::createClient();

        //make the post request with all valid data
        $client->request('POST', '/job' , $job_data);

        //make sure the response was 200 HTTP OK
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $new_job_id = json_decode(
            $client->getResponse()->getContent()
        )
            ->job_id;

        /*
         * INVALID DATA DELETE TEST
         */
        //make the delete request with job id 0
        $client->request('DELETE', '/job/0');

        //make sure the response was 404 HTTP NOT FOUND
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        /*
         * Valid delete test with newly added job
         */
        $client->request('DELETE', '/job/'.$new_job_id );

        //make sure the response was 200 HTTP OK
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Keep the test database in same state
     * Clean up after the tests
     */
    public function tearDown()
    {
        parent::tearDown();

        $kernel = self::bootKernel();

        //Get database access
        $entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        //delete all jobs with ID>2
        $query = $entityManager->createQuery(
            "delete from App\Entity\Job s where s.id > 2"
        );
        $query->execute();

    }

    /**
     * Getter for valid post data
     */
    public function getValidJobData(){
        return $this->valid_job_data;
    }
}