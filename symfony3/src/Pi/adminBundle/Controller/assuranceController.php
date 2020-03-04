<?php
/**
 * Created by PhpStorm.
 * User: ci
 * Date: 16/02/2018
 * Time: 19:58
 */

namespace Pi\adminBundle\Controller;


use Pi\adminBundle\Form\assuranceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pi\adminBundle\Entity\assurance;
use Symfony\Component\HttpFoundation\Request;

class assuranceController extends Controller
{
public function addAssuranceAction(Request $request)
{
    $assurances= new Assurance();
    $form= $this->createForm(assuranceType::class,$assurances);
    $form->handleRequest($request);
    if ($form->isValid())
    {
        $em =$this->getDoctrine()->getManager();
        $assurances->setTotalprix(0);
        $em->persist($assurances);
        $em->flush();
        return $this->redirectToRoute('listAssurance');
    }
    return $this->render("PiAdminBundle:assurance:addAssurance.html.twig",array('form'=>$form->createView()));

}
    public function listAssuranceAction(Request $request)
{

    $em = $this->getDoctrine()->getManager();
    $assurances=$em->getRepository("PiAdminBundle:assurance")->findAll();
    $n=$em->getRepository('PiAdminBundle:assurance')->UpdateAssur();

    return $this->render("PiAdminBundle:assurance:listAssurance.html.twig",array('assurances'=>$assurances,'n'=>$n));


}
    public function deleteAssuranceAction(Request $request)
{
    $id = $request->get('id');
    $em = $this->getDoctrine()->getManager();
    $assurances = $em->getRepository("PiAdminBundle:assurance")->find($id);
    $em->remove($assurances);
    $em->flush();
    return $this->redirectToRoute('listAssurance');
}

    public function rechercheAssuranceAction(Request $request)
{
    $em=$this->getDoctrine()->getManager();
    $assurances=$em ->getRepository("PiAdminBundle:assurance")
        ->findAll();
    if($request->isMethod("post")){
        $nom = $request->get('nom');
        $assurances =$em->getRepository("PiAdminBundle:assurance")
            ->findBy(array('nom'=>$nom));

    }
    return $this->render("PiAdminBundle:assurance:rechercheAssurance.html.twig",array("assurances"=>$assurances));
}

    public function updateAssuranceAction(Request $request)
{
    $id = $request->get('id');
    $em= $this->getDoctrine()->getManager();
    $assurances = $em->getRepository("PiAdminBundle:assurance")->find($id);
    $form= $this->createForm(assuranceType::class,$assurances);
    $form->handleRequest($request);
    if ($form->isValid())
    {
        $em->persist($assurances);
        $em->flush();
        return $this->redirectToRoute('listAssurance');
    }
    return $this->render("PiAdminBundle:assurance:UpdateAssurance.html.twig",array("form"=>$form->createView()));

}
}
