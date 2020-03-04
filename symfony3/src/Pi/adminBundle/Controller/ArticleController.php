<?php
/**
 * Created by PhpStorm.
 * User: ci
 * Date: 26/02/2018
 * Time: 18:10
 */

namespace Pi\adminBundle\Controller;


use Pi\adminBundle\Entity\Article;
use Pi\adminBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{

    public function addArticleAction(Request $request)
    {
        $id= $request->get('id');
        $em =$this->getDoctrine()->getManager();
        $veterinaire = $em->getRepository("PiAdminBundle:Veterinaires")->find($id);
        $article= new Article();
        $form= $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em =$this->getDoctrine()->getManager();
            $article->uploadProfilePicture();
            $article->setVeterinaireId($veterinaire);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('listArticle');
        }
        return $this->render("PiAdminBundle:Article:addArticle.html.twig",array('form'=>$form->createView()));


    }

    public function listArticleAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository("PiAdminBundle:Article")->findAll();
        $a=$em->getRepository('PiAdminBundle:Article')->UpdateArticle();

        return $this->render("PiAdminBundle:Article:listArticle.html.twig", array('articles' => $articles,'a'=>$a));

    }

    public function deleteArticleAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository("PiAdminBundle:Article")->find($id);
        $em->remove($articles);
        $em->flush();
        return $this->redirectToRoute('listArticle');
    }

    public function rechercheArticleAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $articles=$em ->getRepository("PiAdminBundle:Article")
            ->findAll();
        if($request->isMethod("post")){
            $titre = $request->get('titre');
            $articles =$em->getRepository("PiAdminBundle:Article")
                ->findBy(array('titre'=>$titre));

        }
        return $this->render("PiAdminBundle:Article:rechercheArticle.html.twig",array("articles"=>$articles));
    }

    public function updateArticleAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $article = $em->getRepository("PiAdminBundle:Article")->find($id);
        $form= $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('listArticle');
        }
        return $this->render("PiAdminBundle:Article:updateArticle.html.twig",array("form"=>$form->createView()));

    }

    }