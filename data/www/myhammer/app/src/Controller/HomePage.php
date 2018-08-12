<?php
/*
 * This file is part of the MyHammer RESTful API
 *
 * Arslan Afzal <arslanafzal321@gmail.com>
 *
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * We really don't need home page for API
 */
class HomePage extends AbstractController
{
    /**
     * Make the homepage 404
     * @Route("/")
     */
    public function indexAction()
    {
        return new View("Nothing to see here. Please refer to the documentation of the API.", Response::HTTP_NOT_FOUND);
    }
}