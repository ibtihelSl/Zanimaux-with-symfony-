<?php
/**
 * Created by PhpStorm.
 * User: Touha
 * Date: 12/02/2018
 * Time: 23:29
 */

namespace Pi\adminBundle\Controller;


use Pi\adminBundle\Entity\Magasin;
use Pi\adminBundle\Form\MagasinType;
use Pi\FrontBundle\Entity\Avis;
use Pi\FrontBundle\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class MagasinController extends Controller
{
    public function addmagasinAction(Request $request)
    {
        $magasin= new Magasin();
        $form= $this->createForm(MagasinType::class,$magasin);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $em =$this->getDoctrine()->getManager();
            $em->persist($magasin);
            $em->flush();
          return $this->redirectToRoute('listmagasin');
        }
        return $this->render("PiAdminBundle:Magasin:addmagasin.html.twig",array('form'=>$form->createView()));

    }
    public function listmagasinAction()
    {
        $em = $this->getDoctrine()->getManager();
        $magasins=$em->getRepository("PiAdminBundle:Magasin")->findAll();
        return $this->render("PiAdminBundle:Magasin:List.html.twig",array('magasins'=>$magasins));

    }
    public function deletemagasinAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $magasin = $em->getRepository("PiAdminBundle:Magasin")->find($id);
        $em->remove($magasin);
        $em->flush();
        return $this->redirectToRoute('listmagasin');
    }
    public function recherchemagasinAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $magasins=$em ->getRepository("PiAdminBundle:Magasin")
            ->findAll();
        if($request->isMethod("post")){
            $nom = $request->get('nom');
            $magasins =$em->getRepository("PiAdminBundle:Magasin")
                ->findBy(array('nom'=>$nom));

        }

        return $this->render("PiAdminBundle:Magasin:Recherchemagasin.html.twig",array("magasins"=>$magasins));
    }
    public function updatemagasinAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $magasin = $em->getRepository("PiAdminBundle:Magasin")->find($id);
        $form= $this->createForm(MagasinType::class,$magasin);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em->persist($magasin);
            $em->flush();
            return $this->redirectToRoute("listmagasin");
        }
        return $this->render("PiAdminBundle:Magasin:Updatemagasin.html.twig",array("form"=>$form->createView()));

    }
}