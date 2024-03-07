<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ): Response {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request); // permet d'intercepter la requête lancé par la soumission du formulaire

        if ($form->isSubmitted()) {

            if ($form->isValid()) {

                $contact->setDate(new \DateTime);
                $entityManager->persist($contact); // insérer en base
                $entityManager->flush(); // fermer la transaction executée par la bdd

                $this->addFlash(
                    'success',
                    'Votre message a bien été envoyé'
                );

                // rediriger vers une autre page
                // return $this->redirectToRoute(/* ... */);
            }
            // } else {
            //     $errors = $validator->validate($contact);
            // }

        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form,
            'errors' => !isset($errors) ? NULL : $errors
        ]);
    }
}
