<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }


    #[Route('/profil', name: 'app_delete_account')]
    public function deleteAccount(): Response
    {
        return $this->render('profil/modify_profile.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('/profil/modify_info', name: 'app_modify_info')]
    public function modify(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a bien été modifié');
            return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil/modify_profile.html.twig', [
            'profileForm' => $form,
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('/profil', name: 'app_delete_account')]
    public function deleteAcc(): Response
    {
        return $this->render('profil/modify_profile.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
    #[Route('/profil/modify_password', name: 'app_modify_password')]
    public function modifyPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($passwordEncoder->isPasswordValid($user, $form['oldPassword']->getData())) {

                if ($form->isValid()) {
                    $newEncodedPassword = $passwordEncoder->hashPassword($user, $form->get('password')->getData());
                    $user->setPassword($newEncodedPassword);
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash('success', 'Votre profil a bien été modifié');
                    return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
                }
            }
        }

        return $this->render('profil/modify_password.html.twig', [
            'passwordForm' => $form,
            'controller_name' => 'ProfilController',
        ]);
    }


    #[Route('/profil/oubli', name: 'app_profil_oubli')]
    public function mdp_oubli(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
}
