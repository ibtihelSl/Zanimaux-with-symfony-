<?php
/**
 * Created by PhpStorm.
 * User: abdelaziz
 * Date: 14/02/2018
 * Time: 11:40
 */

namespace Pi\adminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pi\adminBundle\Entity\Association;
use Pi\adminBundle\Form\AssociationType;


class AssociationController extends Controller
{



    public function addAction(Request $request)
    {
        $Association= new Association();
        $form= $this->createForm(AssociationType::class,$Association);
        $form->handleRequest($request);
        if ($form->isValid())
        {   $em=$this->getDoctrine()->getManager();
            $em->persist($Association);
            $em->flush();
            //return $this->$form->createView();
            return $this->redirect($this->generateUrl('rechercheAssociation'));

        }
        return $this->render('PiAdminBundle:Association:addAssociation.html.twig',array('form'=>$form->createView()
        ));
    }



    public function listAction()
    {     //Instantier l'Entity Manager
        $em=$this->getDoctrine()->getManager();
        $Associations=$em->getRepository('PiAdminBundle:Association')
            -> findAll();
        return $this->render('PiAdminBundle:Association:listAssociation.html.twig',array('Associations'=>$Associations));

    }

    public function deleteAction(Request $request)
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $Association= $em->getRepository("PiAdminBundle:Association")->find($id);
        $em->remove($Association);
        $em->flush();
        return $this->redirectToRoute('rechercheAssociation');
    }

    public function updateAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        //Recuperation de l'entité Modele qui al'id=$id
        $Association=$em->getRepository('PiAdminBundle:Association')->find($id);
        $form= $this->createForm(AssociationType::class,$Association);
        //controler si la premiere visite ou la deuxieme handleRequest
        $form->handleRequest($request);
        if ($form->isValid())
        {    //valider les donnée sous entity
            $em->persist($Association);
            //exécuter l'action persist
            $em->flush();
            //return $this->$form->createView();
            return $this->redirect($this->generateUrl('rechercheAssociation'));
        }
        return $this->render('PiAdminBundle:Association:updateAssociation.html.twig',array('form'=>$form->createView()
        ));
    }

    public function RechercheAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Associations = $em->getRepository("PiAdminBundle:Association")->findAll();
        if ($request->isMethod("post")){
            $criteria = $request->get('name');

            $Associations = $em->getRepository("PiAdminBundle:Association")->findBy(array('name' => $criteria));}//pays dans class modele


        return $this->render('PiAdminBundle:Association:rechercheAssociation.html.twig', array('Associations' => $Associations));}


}