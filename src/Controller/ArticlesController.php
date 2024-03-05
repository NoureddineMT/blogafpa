<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // EntityManagerInterface $entityManager
        // injection de dépendance ! => je récupérer entityManager pour interragir avec la bdd
        // https://symfony.com/doc/6.4/doctrine.html#fetching-objects-from-the-database

        // je récupère tous mes articles en BDD en passant par entityManager
        // findAll est une méthode générique permettant de faire un selecAll
        $articles = $entityManager->getRepository(Article::class)->findAll();
        // dd($articles); 
        // récupérer tous les articles en BDD
        // et les envoyer à ma vue

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'app_get_article_by_id')]
    public function getArticleById(
        EntityManagerInterface $entityManager,
        int $id): Response
    {
        // pour récupérer le paramètre id en url, j'ai juste à le déclarer en argument de ma méthode

        $article = $entityManager->getRepository(Article::class)->find($id);

        return $this->render('articles/show_article.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/articles/{id_category}', name: 'app_get_article_by_category')]
    public function getArticleByCategory(
        EntityManagerInterface $entityManager,
        int $id_category): Response
    {
        // pour récupérer le paramètre id en url, j'ai juste à le déclarer en argument de ma méthode
        $articles = $entityManager->getRepository(Article::class)->findBy(array('category' => $id_category));

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
