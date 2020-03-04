<?php
/**
 * Created by PhpStorm.
 * User: abdelaziz
 * Date: 24/04/2018
 * Time: 22:08
 */

namespace Pi\adminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Pi\adminBundle\Entity\Event;
use Pi\adminBundle\Form\EventType;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Pi\FrontBundle\Entity\User;



class EventsController extends Controller
{
    public function allAction()
    {
        $Events = $this->getDoctrine()->getManager()
            ->getRepository("PiAdminBundle:Event")
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Events);
        return new JsonResponse($formatted);
    }

    public function findAction($id)
    {
        $Events = $this->getDoctrine()->getManager()
            ->getRepository('PiAdminBundle:Event')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Events);
        return new JsonResponse($formatted);
    }


    public function findusAction()
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('PiFrontBundle:User')
            ->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newCAction(Request $request,$username,$password,$email)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setUsername($username);
        $user->setUsernameCanonical($username);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setEnabled(1);
        $user->setPassword($password);
        $user->setPlainPassword($password);
        $user->setMdp($password);

        $user->setRoles(array("ROLE_CLIENT") );
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    public function findUAction($username,$password)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('PiFrontBundle:User')
            ->findBy([
                "username" => $username,
                "mdp" => $password,
            ]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }


}