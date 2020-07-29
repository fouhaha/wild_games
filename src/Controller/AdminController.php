<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @IsGranted("ROLE_ADMIN")
 * Class AdminController
 * @package App\Controller
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="index")
     */
    public function adminHome()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @param UserRepository $userRepo
     * @return Response
     * @Route("/users", name="users")
     */
    public function users(UserRepository $userRepo): Response
    {
        $users = $userRepo
            ->findAll();

        return $this->render('admin/users.html.twig', ['users' => $users]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @Route("/user/update/{user}", name="user_detail", methods={"GET","POST"})
     * @return Response
     */
    public function updateUserDetail(User $user, Request $request): Response
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

        return $this->render('admin/user.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function deleteUser(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/comments", name="comments")
     * @return Response
     */
    public function findAllComments(): Response
    {
        $comments = $this->em->getRepository(Comment::class)->findByGames();
        return $this->render('admin/comments.html.twig', ['comments' => $comments]);
    }
}
