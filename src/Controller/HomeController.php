<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $articles = $paginator->paginate(
            $articleRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );
       

        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'articles' =>$articles
            

        ]);
    }

    #[Route('/filter/{filter}', name: 'app_home_filter')]
    public function getArticleByFilter(ArticleRepository $articleRepository,
     CategoryRepository $categoryRepository,
      PaginatorInterface $paginator,
       Request $request,
       string $filter): Response
    {
        $articlesData = [];
        foreach($articleRepository->findArticleByFilter($filter) as $article){
            $articleData = [
                'id' => $article->getId(),
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'picture' => $article->getPicture(),
                'date' => $article->getDate()->format('Y-m-d'),
                'category_id' => $article->getCategory() ? $article->getCategory()->getId() : null,
                'category_name' => $article->getCategory() ? $article->getCategory()->getTitle() : null,


            ];
            $articlesData[] = $articleData;
        }


        
            return new JsonResponse($articlesData);
       
    }



    #[Route('/search', name: 'app_search_articles', methods:['GET'])]
    public function getArticleBySearch(
        ArticleRepository $articleRepository,Request $request, PaginatorInterface $paginator ): Response
    {
        if($request->query->has("search")){
            $search = strtolower($request->query->get("search"));
            // dd($articles);

            $articles = $paginator->paginate(
                $articleRepository->findArticlesBySearch($search), /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                2 /*limit per page*/
            );
            return $this->render('article/index.html.twig', [
                'articles' => $articles,
            ]);

        }else{
            return $this->redirectToRoute("app_article_index", [], Response::HTTP_SEE_OTHER);
        }


        
    }



}
