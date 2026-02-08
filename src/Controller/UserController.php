<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/users', name: 'user')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $limit = $request->query->getInt('limit', 10);

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->paginate(
                $request->query->getInt('page', 1),
                $limit,
            ),
        ]);
    }

    #[Route('/users/create', name: 'user.create')]
    public function create(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $password));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/users/{id}', name: 'user.update')]
    public function update(?User $user, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        if (null === $user) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            if ($password) {
                $user->setPassword($passwordHasher->hashPassword($user, $password));
            }

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form,
            'id' => $user->getId(),
        ]);
    }

    #[Route('/users/{id}/delete', name: 'user.delete',)]
    public function delete(?User $user, EntityManagerInterface $em): RedirectResponse
    {
        if (null === $user) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user');
    }
}
