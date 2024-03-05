<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request); // permet d'intercepter la requête lancé par la soumission du formulaire

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($contact); // insérer en base
            $entityManager->flush(); // fermer la transaction executée par la bdd

        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form,
        ]);
    }
}
