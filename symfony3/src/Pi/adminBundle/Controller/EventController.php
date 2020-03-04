<?php
/**
 * Created by PhpStorm.
 * User: abdelaziz
 * Date: 25/02/2018
 * Time: 14:44
 */

namespace Pi\adminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Pi\adminBundle\Entity\Event;
use Pi\adminBundle\Form\EventType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;


class EventController extends Controller
{


    public function addAction(Request $request)
    {
        $Event= new Event();
        $form= $this->createForm(EventType::class,$Event);
        $form->handleRequest($request);
        if ($form->isValid())
        {   $em=$this->getDoctrine()->getManager();
            $Event->setArchive(0);

            $serializer = new Serializer(array(new DateTimeNormalizer('Y-m-d')));

            $y="2018/05/25";
            $db = $serializer->normalize(new \DateTime($y));
            $Event->setDb($db);
            $x="2018/05/26";
            $dbb = $serializer->normalize(new \DateTime($x));
            $Event->setDf($dbb);



            $em->persist($Event);
            $em->flush();
            //return $this->$form->createView();
            return $this->redirect($this->generateUrl('listEvent'));

        }
        return $this->render('PiAdminBundle:Event:addEvent.html.twig',array('form'=>$form->createView()
        ));
    }



    public function listAction()
    {     //Instantier l'Entity Manager
        $em=$this->getDoctrine()->getManager();
        $arch = $em->getRepository("PiAdminBundle:Event")->anciensEvenements();
        foreach ($arch as $a) {
            $a->setArchive(1);


            $em->flush();
        }
        $Events=$em->getRepository('PiAdminBundle:Event')
            -> findAll();



        return $this->render('PiAdminBundle:Event:rechercheEvent.html.twig',array('Events'=>$Events));

    }

    public function deleteAction(Request $request)
    {
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $Event= $em->getRepository("PiAdminBundle:Event")->find($id);
        $em->remove($Event);
        $em->flush();
        return $this->redirectToRoute('listEvent');
    }

    public function updateAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        //Recuperation de l'entité Modele qui al'id=$id
        $Event=$em->getRepository('PiAdminBundle:Event')->find($id);
        $form= $this->createForm(EventType::class,$Event);
        //controler si la premiere visite ou la deuxieme handleRequest
        $form->handleRequest($request);
        if ($form->isValid())
        {    //valider les donnée sous entity
            $em->persist($Event);
            //exécuter l'action persist
            $em->flush();
            //return $this->$form->createView();
            return $this->redirect($this->generateUrl('listEvent'));
        }
        return $this->render('PiAdminBundle:Event:updateEvent.html.twig',array('form'=>$form->createView()
        ));
    }

    public function RechercheAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $Type = $request->get('titre');
            $em = $this->getDoctrine();


            $query = $em->getRepository(Event::class)->createQueryBuilder('u');
            $animeauxrech = $query->where($query->expr()->like('u.titre', ':p'))
                ->setParameter('p', '%' . $Type . '%')
                ->getQuery()->getResult();

            $response = $this->renderView('PiAdminBundle:Event:rechercheAjax.html.twig', array('all' => $animeauxrech));
            return new JsonResponse($response);
        }
        return new JsonResponse(array("status" => true));


    }


    public function showstatAction()
    {

        $em =$this->getDoctrine()->getManager();
        $event = $em->getRepository("PiAdminBundle:Event")->findAll();

        $nbresv = 0;
        foreach ($event as $e)
        {
            $nbresv = $nbresv + $e->getNombreReserve();
        }


        $data= array();
        $stat=['Nom evenement', 'nombre de reservations'];
        array_push($data,$stat);

        foreach ($event as $e)
        {
            $nb = $e->getNombreReserve();

            $stat=array();
            array_push($stat,$e->getTitre(),$nb);
            array_push($data,$stat);
        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->setTitle('résarvations');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);



        return $this->render('PiAdminBundle:Default:chartsa.html.twig',array('piechart' => $pieChart));
    }




}