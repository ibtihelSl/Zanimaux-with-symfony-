<?php

namespace Pi\adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexaAction()
    {
        return $this->render('PiAdminBundle:Default:indexa.html.twig');
    }
    public function layoutAdminAction(){
        $em=$this->getDoctrine()->getManager();


        $m=$em->getRepository('PiAdminBundle:Veterinaires')->UpdateEtat();

        $n=$em->getRepository('PiAdminBundle:assurance')->UpdateAssur();
        $e = $em->getRepository('PiFrontBundle:User')->UpdateUserr();
        $a=$em->getRepository('PiAdminBundle:Article')->UpdateArticle();




        return $this->render("layoutAdmin.html.twig",array('n'=>$n,'m'=>$m ,'e'=>$e,'a'=>$a));

    }
    public function galleryaAction(){
        return $this->render('PiAdminBundle:Default:Gallerya.html.twig');
    }
    public function inboxaAction(){
        return $this->render('PiAdminBundle:Default:Inboxa.html.twig');
    }
    public function chartsaAction(){
        return $this->render('PiAdminBundle:Default:chartsa.html.twig');
    }
    public function calendaraAction(){
        return $this->render('PiAdminBundle:Default:Calendara.html.twig');
    }
    public function petsitteraAction(){
        return $this->render('PiAdminBundle:Default:petsittera.html.twig');
    }
    public function AssociationaAction(){
        return $this->render('PiAdminBundle:Default:Associationsa.html.twig');
    }
    public function VeterinairesaAction(){
        return $this->render('PiAdminBundle:Default:Veternairesa.html.twig');
    }
    public function EvenementsaAction(){
        return $this->render('PiAdminBundle:Default:Evenementsa.html.twig');
    }
    public function annimauxaAction(){
        return $this->render('PiAdminBundle:Default:Annimauxa.html.twig');
    }

}
