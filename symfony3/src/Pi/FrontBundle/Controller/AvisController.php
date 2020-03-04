<?php
/**
 * Created by PhpStorm.
 * User: Touha
 * Date: 28/02/2018
 * Time: 13:00
 */

namespace Pi\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AvisController extends Controller
{

    public function DeleteAvisAction(Request $request,$idmagasin){

        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $avis = $em->getRepository("PiFrontBundle:Avis")->find($id);
        $em->remove($avis);
        $em->flush();
        return $this->redirectToRoute('Accessoires',array("id"=>$idmagasin));


    }

}