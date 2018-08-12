<?php
/*
 * This file is part of the MyHammer RESTful API
 *
 * Arslan Afzal <arslanafzal321@gmail.com>
 *
 */

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Service;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Exposing the CRUD operations on Job Entity via RESTful API
 */
class JobController extends FOSRestController
{
    /**
     * Provide the specific Job details
     * @Route("/job/{job_id}",  methods={"GET"}, requirements={"job_id"="\d+"}, name="job_get")
     */
    public function getAction($job_id)
    {
        //fetch the job from database first
        $job = $this->getDoctrine()
            ->getRepository(Job::class)
            ->find($job_id);

        //If there is no job for given job id, send 404 HTTP NOT FOUND
        if(!$job){
            return new View("The job you requested was not found.", Response::HTTP_NOT_FOUND);
        }

        //send the requested Job data
        return new View($job, Response::HTTP_OK);
    }

    /**
     * Insert a new Job
     * @Route("/job",  methods={"POST"}, name="job_post")
     */
    public function postAction(Request $request, ValidatorInterface $validator)
    {
        //EntityManager for database actions
        $entityManager = $this->getDoctrine()->getManager();

        $job = new Job();

        //set job's attributes
        $service = $entityManager->getRepository(Service::class)->find($request->get("service_id", -1));
        $post_datetime = new \DateTime();
        $job->setTitle($request->get("title", ""))
            ->setDescription($request->get("description", ""))
            ->setZip($request->get("zip", ""))
            ->setCity($request->get("city", ""))
            ->setPostDatetime(new \DateTime())
            ->setService($service);

        //If given action datetime is valid and is in future
        if(strtotime($request->get("action_datetime"))){
            $action_datetime = new \DateTime($request->get("action_datetime"));
            $job->setActionDatetime($action_datetime);
        }

        //check for validation
        $errors = $validator->validate($job);

        if (count($errors) > 0) {
            return new View($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        //save the job
        $entityManager->persist($job);

        // actually executes the query
        $entityManager->flush();

        //send the response
        return new View(array(
            "message" => "Job added successfully.",
            "job_id" => $job->getId()
        ), Response::HTTP_OK);
    }

    /**
     * Update a Job
     * @Route("/job/{job_id}",  methods={"PUT"}, requirements={"job_id"="\d+"}, name="job_put")
     */
    public function putAction($job_id, Request $request, ValidatorInterface $validator)
    {
        //EntityManager for database actions
        $entityManager = $this->getDoctrine()->getManager();

        //get the job data from database
        $job = $entityManager->getRepository(Job::class)->find($job_id);

        //make sure the job ID was correct, else send 404
        if(!$job){
            return new View("Job was not found.", Response::HTTP_NOT_FOUND);
        }

        //set job's attributes
        $service = $entityManager->getRepository(Service::class)->find($request->get("service_id", -1));

        $job->setTitle($request->get("title", ""))
            ->setDescription($request->get("description", ""))
            ->setZip($request->get("zip", ""))
            ->setCity($request->get("city", ""))
            ->setService($service);

        //If given action datetime is valid and is in future
        if(strtotime($request->get("action_datetime"))){
            $action_datetime = new \DateTime($request->get("action_datetime"));
            $job->setActionDatetime($action_datetime);
        }

        $errors = $validator->validate($job);

        if (count($errors) > 0) {
            return new View($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        //save the job
        $entityManager->persist($job);

        // actually executes the query
        $entityManager->flush();

        //send the response
        return new View(array(
            "message" => "Job updated successfully.",
            "job_id" => $job->getId()
        ), Response::HTTP_OK);
    }

    /**
     * Delete a Job
     * @Route("/job/{job_id}",  methods={"DELETE"}, requirements={"job_id"="\d+"}, name="job_delete")
     */
    public function deleteAction($job_id)
    {
        //EntityManager for database actions
        $entityManager = $this->getDoctrine()->getManager();

        //get the job data from database
        $job = $entityManager->getRepository(Job::class)->find($job_id);

        //make sure the job ID was correct, else send 404
        if(!$job){
            return new View("Job was not found.", Response::HTTP_NOT_FOUND);
        }

        //remove the job
        $entityManager->remove($job);

        //execute the query
        $entityManager->flush();

        //send the response
        return new View("Job deleted successfully.", Response::HTTP_OK);
    }
}