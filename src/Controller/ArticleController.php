<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(ArticleRepository $repository)
    {
        $articles = $repository->findLatestPublished();


        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"}, methods="GET")
     */
    public function show(Article $article){

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/new")
     */
    public function new(){
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('content')
            ->add('publishedAt')
            ->getForm();

        return $this->render('article/new.html.twig',[
            'form' => $form->createView(),

        ]);
    }

}
