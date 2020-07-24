<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{user}", name="app_profile")
     * @param User $user
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function profile(User $user, Request $request):Response
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

            return $this->redirectToRoute('app_profile', ['user' => $user->getId()]);
        }

        return $this->render('profile/profile.html.twig', ['form' => $form->createView()]);
    }
}
