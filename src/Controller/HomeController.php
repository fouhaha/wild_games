<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index()
    {
//         if ($this->getUser()) {
//             return $this->redirectToRoute('/**A définir, certainement game_index/');
//         }

        return $this->render('home.html.twig');
    }
}
