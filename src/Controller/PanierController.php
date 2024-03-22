<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\User;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function afficherPanier(Request $request, ProduitRepository $produitRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
        
        
        $session = $request->getSession();
        $panierKey = 'panier_'.$user->getId();
        $panierOrder = $session->get($panierKey, []);
    
        $produits = [];
        $total = 0;
    
        foreach ($panierOrder as $id => $quantite) {
            $produit = $produitRepository->find($id);
            if ($produit) {
                $produits[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'sousTotal' => $produit->getPrice() * $quantite
                ];
                $total += $produit->getPrice() * $quantite;
            }
        }
        //dd($produits);


         
        return $this->render('panier/index.html.twig', [
            'produits' => $produits,
            'total' => $total,
        ]);
    }

    #[Route('/panier/valider', name: 'app_panier_valider')]
    public function uploadPanier(Request $request, ProduitRepository $produitRepository, EntityManagerInterface $em,User $user): Response
    {
        // $panier = new Panier();
        // $panier->setUser($user->getId());
        // $panier->setAmount($produit->getPrice() * $quantite);
        // $panier->setDate(new\DateTime);
        // $panier->setState("En anntend");

        return $this->redirectToRoute('app_produit_index');
}
}
