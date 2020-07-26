<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
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

    /**
     * @param User $user
     * @param Request $request
     * @Route("/user/{user}", name="user_detail")
     * @return Response
     */
    public function userDetail(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isSubmitted()) {
                var_dump($form->getData());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_users', ['user' => $user->getId()]);
        }

        return $this->render('admin/user.html.twig', ['form' => $form->createView()]);
    }

}
