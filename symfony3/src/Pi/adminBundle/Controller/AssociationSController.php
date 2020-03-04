<?php
/**
 * Created by PhpStorm.
 * User: abdelaziz
 * Date: 26/04/2018
 * Time: 00:17
 */

namespace Pi\adminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Pi\adminBundle\Entity\Association;
use Pi\adminBundle\Form\EventType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class AssociationSController  extends Controller
{

    public function allAction()
    {
        $Associations = $this->getDoctrine()->getManager()
            ->getRepository("PiAdminBundle:Association")
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Associations);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $Associations = $this->getDoctrine()->getManager()
            ->getRepository('PiAdminBundle:Association')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Associations);
        return new JsonResponse($formatted);
    }

}