<?php
/**
 * Created by PhpStorm.
 * User: abdelaziz
 * Date: 19/02/2018
 * Time: 23:50
 */

namespace Pi\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Pi\FrontBundle\Entity\Participants;
use Pi\FrontBundle\Entity\User;



class ParticipantsController extends Controller
{


    public function notificationAction()
    {  $user = $this->getUser();
        $g= $user->getEmail();
        $em=$this->getDoctrine()->getManager();
        $participant=$em->getRepository('PiFrontBundle:Participants')->notification($g);
        return $this->render('PiFrontBundle:Default:notification.html.twig',array('participant'=>$participant));




    }
}