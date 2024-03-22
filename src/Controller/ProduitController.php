<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Repository\ArticleRepository;

use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET', 'POST'])]
    public function show(Produit $produit, Request $request, EntityManagerInterface $entityManager): Response
    {

        $entityManager->flush();

        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/add', name: 'app_produit_add', methods: ['GET', 'POST'])]
    public function ajouterArticleAction(Request $request,EntityManagerInterface $entityManager, $id)
    {
        
        $user = $this->getUser();
        if (!$user) {
            
            return $this->redirectToRoute('app_login');
        }
        $panier = new Panier();
        
        $session = $request->getSession();
        
        
        $panierKey = 'panier_'.$user->getId();
        $orderPanier = $session->get($panierKey, []);
        
        
        if (!empty($orderPanier[$id])) {
            $orderPanier[$id]++;
        } else {
            
            $orderPanier[$id] = 1;
        }
        
        
        $session->set($panierKey, $orderPanier);
        //dd($session->get($panierKey));
  
        return $this->redirectToRoute('app_panier', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'app_produit_delete', methods: ['GET', 'POST'])]
    public function supprimerArticleAction(Request $request, $id)
    {
        // Similaire à l'ajout mais pour supprimer ou ajuster les quantités
    }


}