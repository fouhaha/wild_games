<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    /**
     * @param UserRepository $userRepo
     * @Route("/scoreboard", name="app_scoreboard")
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function score(UserRepository $userRepo)
    {
        $scores = $userRepo->findByScore();

        return $this->render('score/scores.html.twig', ['scores' => $scores]);
    }
}
