<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LuckyController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {

    }

/*    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('number.html.twig', ['number' => $number]);
    }*/
}