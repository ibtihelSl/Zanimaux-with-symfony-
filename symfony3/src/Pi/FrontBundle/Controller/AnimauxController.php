<?php

namespace Pi\FrontBundle\Controller;

use Pi\FrontBundle\Entity\Animaux;
use Pi\FrontBundle\Form\AnimauxType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AnimauxController extends Controller
{
    public function annimauxaAction(Request $request)
    {
        $animaux = new Animaux();
        $form=$this->createForm(AnimauxType::class,$animaux);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {

            $em=$this->getDoctrine()->getManager();
            $animaux->uploadProfilePicture();
            $us = $em->getRepository('PiFrontBundle:User')->find($user);
            $animaux->setIduser($us);
            $em->persist($animaux);
            $em->flush();
            // return $this->redirectToRoute("esprit_parc_list");

        }



        return $this->render("PiAdminBundle:Default:Annimauxa.html.twig",array(
            'form'=>$form->createView()
        ));
    }








    public function afficheAnimauxAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $animauxs=$em->getRepository("PiFrontBundle:Animaux")->findAll();

        if($request->isMethod('POST'))
        {

            $nomrace=$request->get('aa');


            $animauxs=$em->getRepository("PiFrontBundle:Animaux")->findBy(array("nomA"=>$nomrace));
            if(count($animauxs)==0) {
                $animauxs = $em->getRepository("PiFrontBundle:Animaux")->findBy(array("race" => $nomrace));
            }
        }


        return $this->render("PiAdminBundle:Default:listAnimaux.html.twig",array(
            'animauxs'=>$animauxs
        ));
    }

    public function deleteAnimauxAction(Request $request , $id)
    {

        $em = $this->getDoctrine()->getManager();

        $animaux=$em->getRepository("PiFrontBundle:Animaux")->find($id);

        $em->remove($animaux);
        $em->flush();

        return $this->redirectToRoute("listannimauxa");
    }

    public function updateAnimauxAction(Request $request , $id)
    {
        $em=$this->getDoctrine()->getManager();

        $animaux=$em->getRepository("PiFrontBundle:Animaux")->find($id);

        $form= $this->createForm(AnimauxType::class,$animaux);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {



            $em->persist($animaux);
            $em->flush();
            return $this->redirectToRoute("listannimauxa");
        }
        return $this->render("PiAdminBundle:Default:UpdateAnimaux.html.twig",array(
            'form'=>$form->createView()
        ));

    }


    public function afficheAnimauxfAction(Request $request )
    {

        $em=$this->getDoctrine()->getManager();

        $animauxs = $em->getRepository(Animaux::class)->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator

         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $animauxs,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',2)
        );

        return $this->render("PiAdminBundle:Default:listAnimauxf.html.twig",array(
            'animauxs'=>$result
        ));

    }

    public function newAction(Request $request)
    {

        $animaux = new Animaux();
        $em = $this->getDoctrine()->getManager();

        $animaux->setNomA($request->get('nom_a'));
        $animaux->setRace($request->get('race'));
        $animaux->setAge($request->get('age'));
        $animaux->setPoids($request->get('poids'));
        //  $animaux->setTelephoneprop($request->get('telephoneprop'));
        $animaux->setNomImage($request->get('nomImage'));
        $em->persist($animaux);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($animaux);
        return new JsonResponse($formatted);



    }

    public function updateanimalMobileAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $magasin = $em->getRepository("PiFrontBundle:Animaux")->find($id);
        $magasin->setNomA($request->get('nom_a'));
        $magasin->setAge($request->get('age'));
        $magasin->setPoids($request->get('poids'));
        $magasin->setRace($request->get('race'));
        $em->persist($magasin);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($magasin);
        return new JsonResponse($formatted);

    }



    public function allAnimauxAction()
    {

        $animaux = $this->getDoctrine()->getManager()->getRepository("PiFrontBundle:Animaux")->findAll();
        $Serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $Serializer->normalize($animaux);

        return new JsonResponse($formatted);
    }



    public function deleteAnimalnMobileAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $magasin = $em->getRepository("PiFrontBundle:Animaux")->find($id);
        $em->remove($magasin);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($magasin);
        return new JsonResponse($formatted);
    }



}
