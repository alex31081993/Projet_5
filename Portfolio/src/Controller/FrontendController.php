<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class FrontendController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {

        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'FrontendController',
        ]);
    }
    /**
     * @Route("/mentions-legales", name="mentionsLegales")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mentionsLegales()
    {
        return $this->render('mentions_legales/index.html.twig', [
            'controller_name' => 'FrontendController',

        ]);
    }
}