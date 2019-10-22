<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/new", methods={"GET","POST"})
     */
    public function new(Request $request){
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('content')
            ->add('publishedAt', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('writtenBy', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_article_show', [
                'id' => $article->getId(),
            ]);

        }

        return $this->render('article/new.html.twig',[
            'form' => $form->createView(),

        ]);
    }

}
