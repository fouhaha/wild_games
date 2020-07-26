<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 * Class AdminController
 * @package App\Controller
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function adminHome()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepo
     * @return Response
     * @Route("/users", name="users")
     */
    public function users(Request $request, UserRepository $userRepo): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)
            ->findAll();

        return $this->render('admin/users.html.twig', ['users' => $users]);
    }

}
