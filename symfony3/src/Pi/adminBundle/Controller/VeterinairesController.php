<?php
/**
 * Created by PhpStorm.
 * User: ci
 * Date: 13/02/2018
 * Time: 18:11
 */

namespace Pi\adminBundle\Controller;


use Pi\adminBundle\Entity\Veterinaires;
use Pi\adminBundle\Form\VeterinairesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class VeterinairesController extends Controller
{
    public function addVeterinaireAction(Request $request)
    {
        $veterinaire= new Veterinaires();
        $form= $this->createForm(VeterinairesType::class,$veterinaire);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em =$this->getDoctrine()->getManager();
            $veterinaire->uploadProfilePicture();
            $em->persist($veterinaire);
            $em->flush();
           return $this->redirectToRoute('listVeterinaire');
        }
        return $this->render("PiAdminBundle:Veterinaires:addVeterinaire.html.twig",array('form'=>$form->createView()));

    }
    public function listVeterinaireAction()
    {
       $em=$this->getDoctrine()->getManager();

        $veterinaires=$em->getRepository("PiAdminBundle:Veterinaires")->findAll();
        $m=$em->getRepository('PiAdminBundle:Veterinaires')->UpdateEtat();
        return $this->render("PiAdminBundle:Veterinaires:ListVeterinaire.html.twig",array('veterinaires'=>$veterinaires,'m'=>$m));


}
    public function deleteVeterinaireAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $veterinaires = $em->getRepository("PiAdminBundle:Veterinaires")->find($id);
        $em->remove($veterinaires);
        $em->flush();
        return $this->redirectToRoute('listVeterinaire');
    }

    public function rechercheVeterinaireAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $veterinaires=$em ->getRepository("PiAdminBundle:Veterinaires")
            ->findAll();
      if($request->isMethod("post")){
            $nom = $request->get('nom');
            $veterinaires =$em->getRepository("PiAdminBundle:Veterinaires")
                ->findBy(array('nom'=>$nom));




        }
        return $this->render("PiAdminBundle:Veterinaires:rechercheVeterinaire.html.twig",array("veterinaires"=>$veterinaires));
    }

    public function updateVeterinaireAction(Request $request)
    {
        $id = $request->get('id');
        $em= $this->getDoctrine()->getManager();
        $veterinaire = $em->getRepository("PiAdminBundle:Veterinaires")->find($id);
        $form= $this->createForm(VeterinairesType::class,$veterinaire);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $em->persist($veterinaire);
            $em->flush();
            return $this->redirectToRoute('listVeterinaire');
        }
        return $this->render("PiAdminBundle:Veterinaires:UpdateVeterinaire.html.twig",array("form"=>$form->createView()));

    }
}
