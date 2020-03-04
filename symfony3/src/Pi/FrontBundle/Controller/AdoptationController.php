<?php

namespace Pi\FrontBundle\Controller;

use Pi\FrontBundle\Entity\Adoptation;
use Pi\FrontBundle\Form\AdoptationType;
use Pi\FrontBundle\PiFrontBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AdoptationController extends Controller
{
    public function liveSearchAction(Request $request)
    {

        $req = $request->request->get('q');

        $em = $this->getDoctrine()->getManager();
        $adoptation = $em->getRepository('PiFrontBundle:Adoptation')->findAdoptionByNomprop($req);

       return new JsonResponse($adoptation);

    }

    public function adoptationAction(Request $request)
    {
        $adoptation = new Adoptation();
        $form = $this->createForm(AdoptationType::class, $adoptation);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $us = $em->getRepository('PiFrontBundle:User')->find($user);
            $adoptation->setUser($us);
            $em->persist($adoptation);
            $em->flush();
            // return $this->redirectToRoute("esprit_parc_list");

        }
        return $this->render("PiAdminBundle:Default:Adoptation.html.twig",array(
            'form'=>$form->createView()
        ));
    }



    public function afficheAdoptationAction()
    {

        $em=$this->getDoctrine()->getManager();

        $adoptations = $em->getRepository(Adoptation::class)->findAll();

        return $this->render("PiAdminBundle:Default:listAdoptation.html.twig",array(
            'adoptations'=>$adoptations
        ));

    }
    public function afficheAdoptationfAction()
    {

        $em=$this->getDoctrine()->getManager();

        $adoptations = $em->getRepository(Adoptation::class)->findAll();

        return $this->render("PiAdminBundle:Default:listAdoptationf.html.twig",array(
            'adoptations'=>$adoptations
        ));

    }

    public function deleteAdoptationAction(Request $request , $id)
    {

        $em = $this->getDoctrine()->getManager();

        $adoptation=$em->getRepository("PiFrontBundle:Adoptation")->find($id);

        $em->remove($adoptation);
        $em->flush();

        return $this->redirectToRoute("listadoptation");
    }


    public function updateAdoptationAction(Request $request , $id)
    {
        $em=$this->getDoctrine()->getManager();

        $adoptation=$em->getRepository("PiFrontBundle:Adoptation")->find($id);

        $form= $this->createForm(AdoptationType::class,$adoptation);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {



            $em->persist($adoptation);
            $em->flush();
            return $this->redirectToRoute("listadoptation");
        }
        return $this->render("PiAdminBundle:Default:updateAdoptation.html.twig",array(
            'form'=>$form->createView()
        ));

    }

    public function addadopterMobileAction($idu,$ide )
    {

        $em=$this->getDoctrine()->getManager();
        $animaux=$em->getRepository('PiFrontBundle:Animaux')->find($ide);
        $User=$em->getRepository('PiFrontBundle:User')->find($idu);
        $adoption=new Adoptation();
        $x=$animaux->getNomA();
        $y=$animaux->getId();
        $g=$User->getUsername();

        $adoption->setNomprop($g);
        $adoption->setEspece($x);
        $adoption->setUser($User);
        $adoption->setAnimaux($animaux);



        $em->persist($adoption);

        $em->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($adoption);
        return new JsonResponse($formatted);




    }

    public function allAdoptionMobileAction()
    {
        $adoption = $this->getDoctrine()->getManager()
            ->getRepository("PiFrontBundle:Adoptation")
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($adoption);
        return new JsonResponse($formatted);
    }


    public function findadopAction($idu , $ide)
    {
        $em=$this->getDoctrine()->getManager();

        $test = $em->getRepository('PiFrontBundle:Adoptation')->findBy([
            "user" => $idu,
            "animaux" => $ide,
        ]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($test);
        return new JsonResponse($formatted);
    }






}



