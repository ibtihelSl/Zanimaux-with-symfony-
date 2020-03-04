<?php
/**
 * Created by PhpStorm.
 * User: abdelaziz
 * Date: 30/04/2018
 * Time: 22:14
 */

namespace Pi\FrontBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pi\FrontBundle\Entity\Participants;
use Pi\FrontBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class participerMobileController extends Controller
{


    public function participerEventAction($idu,$ide )
    {

        $em=$this->getDoctrine()->getManager();
        $Event=$em->getRepository('PiAdminBundle:Event')->find($ide);
        $User=$em->getRepository('PiFrontBundle:User')->find($idu);
        $Participants=new Participants();
        $x=$Event->getTitre();
        $y=$Event->getDateDebut();
        $e=$Event->getNombreReserve();
        $f=$Event->getAdresse();
        $g=$User->getEmail();

            $e=$e+1;
            $Participants->setTitre($x);
            $Participants->setDateDebut($y);
            $Participants->setParticipant($g);
            $Participants->setAdresse($f);
            $Participants->setIde($ide);
            $Participants->setIdu($idu);

            $Event->setNombreReserve($e);

            $em->persist($Event);
            $em->persist($Participants);
            $em->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Participants);
        return new JsonResponse($formatted);




    }

    public function allParticipantAction()
    {
        $participants = $this->getDoctrine()->getManager()
            ->getRepository("PiFrontBundle:Participants")
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($participants);
        return new JsonResponse($formatted);
    }


    public function findparticAction($idu , $ide)
    {
        $em=$this->getDoctrine()->getManager();

        $test = $em->getRepository('PiFrontBundle:Participants')->findBy([
            "idu" => $idu,
            "ide" => $ide,
        ]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($test);
        return new JsonResponse($formatted);
    }





}