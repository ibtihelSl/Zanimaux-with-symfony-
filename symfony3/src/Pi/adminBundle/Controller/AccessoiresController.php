<?php
/**
 * Created by PhpStorm.
 * User: Touha
 * Date: 21/02/2018
 * Time: 13:55
 */

namespace Pi\adminBundle\Controller;


use Pi\adminBundle\Entity\Accessoires;
use Pi\adminBundle\Entity\Magasin;
use Pi\adminBundle\Form\AccessoiresType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccessoiresController extends Controller
{

    public function addaccessoireAction(Request $request)
     {
         $id = $request->get('id');
         $em=$this->getDoctrine()->getManager();
         $magasin=$em->getRepository("PiAdminBundle:Magasin")->find($id);
         $accessoire= new Accessoires();
         $form=$this->createForm(AccessoiresType::class,$accessoire);
         $form->handleRequest($request);
         if ($form->isSubmitted())
         {
             $em=$this->getDoctrine()->getManager();
             $accessoire->setIdMagasin($magasin);
             $em->persist($accessoire);
             $em->flush();
             return $this->redirectToRoute("listeaccessoire");
         }
         return $this->render("PiAdminBundle:Accessoires:addaccessoire.html.twig",array("form"=>$form->createView()));
    }
    public function updateaccessoireAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $accessoire = $em->getRepository("PiAdminBundle:Accessoires")->find($id);
        $form= $this->createForm(AccessoiresType::class,$accessoire);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em->persist($accessoire);
            $em->flush();
            return $this->redirectToRoute("listeaccessoire");
        }
        return $this->render("PiAdminBundle:Accessoires:updateaccessoire.html.twig",array("form"=>$form->createView()));
    }

    public function listeaccessoireAction()
    {
        $em = $this->getDoctrine()->getManager();
        $accessoires=$em->getRepository("PiAdminBundle:Accessoires")->findAll();
        return $this->render("PiAdminBundle:Accessoires:listeaccessoires.html.twig",array('accessoires'=>$accessoires));

    }

    public function supprimeraccessoireAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $accessoire = $em->getRepository("PiAdminBundle:Accessoires")->find($id);
        $em->remove($accessoire);
        $em->flush();
        return $this->redirectToRoute('listeaccessoire');
    }

    public function rechercheraccessoiresAction (Request $request){

        $criteria=$request->get('pr');
        $em=$this->getDoctrine()->getManager();
        $accessoires=$em->getRepository('PiAdminBundle:Accessoires')->findAll();

        if($request->isMethod('post')){

            $accessoires=$em->getRepository('PiAdminBundle:Accessoires')->findacc($request->get('no'),$criteria);

        }
        return $this->render('PiAdminBundle:Accessoires:rechercheaccessoire.html.twig',array("accessoires"=>$accessoires));
    }



}