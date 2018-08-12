<?php
/*
 * This file is part of the MyHammer RESTful API
 *
 * Arslan Afzal <arslanafzal321@gmail.com>
 *
 */

namespace App\Controller;

use App\Entity\Service;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Exposing the retrieve operation on Service Entity Collection via RESTful API
 */
class ServiceController extends FOSRestController
{
    /**
     * Provide the complete list of all services
     * @Route("/services",  methods={"GET"}, name="service_list")
     */
    public function getAction()
    {
        //fetch all of the services from database
        $services = $this->getDoctrine()
            ->getRepository(Service::class)
            ->findAll();

        return new View($services, Response::HTTP_OK);
    }
}