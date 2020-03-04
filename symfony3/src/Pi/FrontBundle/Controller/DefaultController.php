<?php

namespace Pi\FrontBundle\Controller;

use Pi\adminBundle\Entity\assurance;
use Pi\adminBundle\Entity\Veterinaires;
use Pi\FrontBundle\Entity\Avis;
use Pi\FrontBundle\Entity\comment;
use Pi\FrontBundle\Form\AvisType;
use Pi\FrontBundle\Form\commentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Pi\adminBundle\Entity\Accessoires;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Pi\FrontBundle\Entity\User;
use Pi\FrontBundle\Entity\Participants;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PiFrontBundle:Default:index.html.twig');
    }
    public function layoutAction()
    {


        return $this->render('layout.html.twig');
    }
    public function AboutAction()
    {
        return $this->render('PiFrontBundle:Default:About.html.twig');
    }
    public function AdoptionAction()
    {
        $em=$this->getDoctrine()->getManager();

        $adoptations = $em->getRepository("PiFrontBundle:Adoptation")->findAll();
        return $this->render('PiFrontBundle:Default:Adoption.html.twig',array('adoptations'=>$adoptations));
    }
    public function MagasinsAction(Request $request)
    {
        $avis= new Avis();
        $form= $this->createForm(AvisType::class,$avis);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $em =$this->getDoctrine()->getManager();
            $em->persist($avis);
            $em->flush();
        }
        $em = $this->getDoctrine()->getManager();
        $avis=$em->getRepository("PiFrontBundle:Avis")->findAll();
        $em = $this->getDoctrine()->getManager();
        $magasins=$em->getRepository("PiAdminBundle:Magasin")->findAll();
        return $this->render("PiFrontBundle:Default:Magasins.html.twig",array('magasins'=>$magasins, 'form'=>$form->createView(),"avis"=>$avis));
    }
    public function VeterinairesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $veterinaires=$em->getRepository("PiAdminBundle:Veterinaires")->findAll();


        return $this->render("PiFrontBundle:Default:Veterinaires.html.twig",array('veterinaires'=>$veterinaires));
    }
    public function AssurancesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $assurances=$em->getRepository("PiAdminBundle:assurance")->findAll();

        return $this->render("PiFrontBundle:Default:Assurances.html.twig",array('assurances'=>$assurances));

    }
    public function calculerAction(Request $request)
    {

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $assurancess =$em->getRepository("PiAdminBundle:assurance")->findOneBy(array('id'=>$id));



        $nbanimaux = $request->get('nbanimaux');

        dump($nbanimaux);



        $prix=$assurancess->getPrixparanimaux();
        $tot=$nbanimaux*$prix;
        $assurancess->setTotalprix($tot);
        $em->persist($assurancess);
        $em->flush();



        $em = $this->getDoctrine()->getManager();
        $assurances=$em->getRepository("PiAdminBundle:assurance")->findAll();
        return $this->render("PiFrontBundle:Default:Assurances.html.twig",array('assurances'=>$assurances,'assurancess'=>$assurancess));

    }
    public function ArticleAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository("PiAdminBundle:Article")->findBy(array('veterinaire_id'=>$id));

        return $this->render('PiFrontBundle:Default:Article.html.twig',array('articles'=>$articles));
    }

    public function ArticleDetailsAction(Request $request){

        //affichage de l'article
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $articles=$em->getRepository("PiAdminBundle:Article")->findBy(array('id'=>$id));

        $comm=$em->getRepository("PiFrontBundle:comment")->findBy(array('article_id'=>$id));

        $m=$em->getRepository('PiFrontBundle:comment')->UpdateEtat($id);

        $user =$this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $art =$em->getRepository("PiAdminBundle:Article")->find($id);
        //ajout de commentaire
        $comment = new comment();
        $form = $this->createForm(commentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $comment->setLastTime(new \DateTime());
            $comment->setArticleId($art);
            $us= $em->getRepository("PiFrontBundle:User")->find($user);
            $comment->setUserId($us);
            $em->persist($comment);




            $em->flush();
            return $this->redirectToRoute("ArticleDetails",array('id'=>$id));
        }
        //Affichage commentaire
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository("PiFrontBundle:comment")
            ->findAll();

        return $this->render('PiFrontBundle:Default:ArticleDetails.html.twig',array('id'=>$id,'articles'=>$articles, 'form' => $form->createView(),'comments' =>$comm,'m'=>$m));


    }


    public function deleteCommentAction(Request $request,$idarticle)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository("PiFrontBundle:comment")->find($id);
        $em->remove($comments);
        $em->flush();
        return $this->redirectToRoute("ArticleDetails",array("id"=>$idarticle));
    }

    public function EvenementsAction()
    {
        $em=$this->getDoctrine()->getManager();
        $Events=$em->getRepository('PiAdminBundle:Event')
            -> findAll();
        foreach ($Events as $Event) {
            $serializer = new Serializer(array(new DateTimeNormalizer('Y-m-d')));

            $y="2019/05/24";
            $db = $serializer->normalize(new \DateTime($y));
            $Event->setDb($db);


            $em->flush();
        }
        return $this->render('PiFrontBundle:Default:Evenements.html.twig',array('Events'=>$Events));
    }
    public function AssociationsAction()
    {
        $em=$this->getDoctrine()->getManager();
        $Associations=$em->getRepository('PiAdminBundle:Association')
            -> findAll();
        return $this->render('PiFrontBundle:Default:Associations.html.twig',array('Associations'=>$Associations));
    }


    public function SanteAction()
    {
        return $this->render('PiFrontBundle:Default:Sante.html.twig');
    }
    public function SupportAdoptionAction()
    {
        return $this->render('PiFrontBundle:Default:SupportAdoption.html.twig');
    }
    public function PlusEventAction()
    {
        return $this->render('PiFrontBundle:Default:PlusEvent.html.twig');
    }
    public function ContactUsAction()
    {
        return $this->render('PiFrontBundle:Default:ContactUs.html.twig');
    }
    public function mapAction()
    {
        $name='name';
        return $this->render('PiFrontBundle:Default:map.html.twig', array('name'=>$name));
    }
    public function AccessoiresAction(Request $request)
    {
        $id = $request->get('id');
        $em=$this->getDoctrine()->getManager();
        $magasin=$em->getRepository("PiAdminBundle:Magasin")->find($id);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $avis= new Avis();
        $form= $this->createForm(AvisType::class,$avis);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $em =$this->getDoctrine()->getManager();
            $avis->setIdMagasin($magasin);
            $ev = $em->getRepository('PiFrontBundle:User')->find($user);
            $avis->setIdUser($ev);
            $em->persist($avis);
            $em->flush();
        }
        $em = $this->getDoctrine()->getManager();
        $avis=$em->getRepository("PiFrontBundle:Avis")->findBy(array('id_magasin'=>$id));
        $accessoires=$em->getRepository("PiAdminBundle:Accessoires")->findBy(array('id_magasin'=>$id));
        return $this->render('PiFrontBundle:Default:Accessoires.html.twig',array('id'=>$id,'accessoires'=>$accessoires,'form'=>$form->createView(),"avis"=>$avis));
    }

    public function likerAccessoireAction(Request $request,$idmagasin)
    {
        $id =$request->get('id');
        $em=$this->getDoctrine()->getManager();

        $accessoire =$em->getRepository(Accessoires::class)->find($id);

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ( $this->ifExist($accessoire->getUsersLike(),$user))
        {
            $accessoire->removeUsersLike($user);
            $accessoire->setNblike($accessoire->getNblike()-1);
        }
        else{
            $accessoire->addUsersLike($user);
            $accessoire->setNblike($accessoire->getNblike()+1);
        }



        $em->flush();

        return $this->redirectToRoute('Accessoires',array("id"=>$idmagasin));

    }
    function ifExist($acc,$user)
    {

        foreach ($acc as $item )
        {
            if ($item == $user)
            {
                return true;
            }
        }
        return false;
    }




    public function readMoreEventAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        //Recuperation de l'entité Modele qui al'id=$id
        $Event=$em->getRepository('PiAdminBundle:Event')->find($id);


        return $this->render('PiFrontBundle:Default:readMoreEvent.html.twig',array('Event' => $Event));
    }


    /**
     * @param $id
     * @return Response
     */
    public function participerEventAction($id)
    {   $user = $this->getUser();
        $g= $user->getEmail();
        $em=$this->getDoctrine()->getManager();
        $Event=$em->getRepository('PiAdminBundle:Event')->find($id);
        $Participants=new Participants();
        $x=$Event->getTitre();
        $y=$Event->getDateDebut();
        $z=$Event->getNombrePlace();
        $e=$Event->getNombreReserve();
        $f=$Event->getAdresse();
        if($e < $z)
        {
            $e=$e+1;
            $Participants->setTitre($x);
            $Participants->setDateDebut($y);
            $Participants->setParticipant($g);
            $Participants->setAdresse($f);
            $Event->setNombreReserve($e);

            $em->persist($Event);
            $em->persist($Participants);
            $em->flush();


        } else
        { return $this->render('PiFrontBundle:Default:EventSature.html.twig'); }


        $em=$this->getDoctrine()->getManager();
        $Events=$em->getRepository('PiAdminBundle:Event')
            -> findAll();
        return $this->render('PiFrontBundle:Default:Evenements.html.twig',array('Events'=>$Events));

    }


    public function AllVeterinaireAction()
    {

        $veterinaire = $this->getDoctrine()->getManager()
            ->getRepository('PiAdminBundle:Veterinaires')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($veterinaire);

        return new JsonResponse($formatted);
    }


    public function AllAssuranceAction()
    {

        $assurance = $this->getDoctrine()->getManager()
            ->getRepository('PiAdminBundle:assurance')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($assurance);

        return new JsonResponse($formatted);
    }

    public function AllArticleAction()
    {

        $article = $this->getDoctrine()->getManager()
            ->getRepository('PiAdminBundle:Article')->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($article);

        return new JsonResponse($formatted);
    }

    public function findCommentAction(Request $request)
    {
        $id = $request->get('id');

        $Comment = $this->getDoctrine()->getManager()->getRepository("PiFrontBundle:comment")
            ->findBy(array('article_id' => $id));
        $Serializer = new Serializer([new ObjectNormalizer]);
        $formatted = $Serializer->normalize($Comment);

        return new JsonResponse($formatted);
    }

    public function AjouterrCommentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $q = new comment();
        $q->setMessage($request->get("message"));

        $em->persist($q); // insert into table
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($q);
        return new JsonResponse($formatted);

    }


    public function AjouterrVetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $vet = new Veterinaires();

        $vet->setNom($request->get('nom'));
        $vet->setAddress($request->get('address'));
        $vet->setVille($request->get('ville'));
        $vet->setPhone($request->get('phone'));
        $vet->setEmail($request->get('email'));


        $em->persist($vet);
        $em->flush();
        $Serializer = new Serializer([new ObjectNormalizer]);
        $formatted = $Serializer->normalize($vet);

        return new JsonResponse($formatted);
    }

    public function AjouterrArticleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $art = new \Pi\adminBundle\Entity\Article();

        $art->setTitre($request->get('Titre'));
        // $art->setDescription($request->get('description'));
        //  $art->setDate($request->get('date'));
        //$art->setVeterinaireId($request->get('veterinaire_id'));

        $art->setDetails($request->get('Details'));


        $em->persist($art);
        $em->flush();
        $Serializer = new Serializer([new ObjectNormalizer]);
        $formatted = $Serializer->normalize($art);

        return new JsonResponse($formatted);
    }

    public function AjouterrAsuuranceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $art=new assurance();

        $art->setNom($request->get('nom'));
        $art->setAdresse($request->get('adresse'));
        $art->setMail($request->get('mail'));
        $art->setDescription($request->get('description'));

        //  $art->setAgeDeCeAnimal($request->get('ageDeCeAnimal'));
        // $art->setTypeDeCeAnimal($request->get('typeDeCeAnimal'));

        $art->setPrixparanimaux($request->get('prixparanimaux'));


        $em->persist($art);
        $em->flush();
        $Serializer = new Serializer([new ObjectNormalizer]);
        $formatted = $Serializer->normalize($art);

        return new JsonResponse($formatted);
    }


    public function updateCommentMobileAction(Request $request)
    {

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $Comment = $em->getRepository("PiFrontBundle:comment")->find($id);
        $Comment->setMessage($request->get('message'));

        $em->persist($Comment);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Comment);
        return new JsonResponse($formatted);

    }
    public function deleteCommentMobileAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $Comment = $em->getRepository("PiFrontBundle:comment")->find($id);
        $em->remove($Comment);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Comment);
        return new JsonResponse($formatted);
    }
    public function updateVetMobileAction(Request $request)
    {

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $vet = $em->getRepository("PiAdminBundle:Veterinaires")->find($id);

        $vet->setNom($request->get('nom'));
        $vet->setAddress($request->get('address'));
        $vet->setVille($request->get('ville'));
        $vet->setPhone($request->get('phone'));
        $vet->setEmail($request->get('email'));

        $em->persist($vet);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($vet);
        return new JsonResponse($formatted);

    }
    public function deleteVetMobileAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $vet = $em->getRepository("PiAdminBundle:Veterinaires")->find($id);
        $em->remove($vet);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($vet);
        return new JsonResponse($formatted);
    }

    public function updateArticletMobileAction(Request $request)
    {

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $Art = $em->getRepository("PiAdminBundle:Article")->find($id);

        $Art->setTitre($request->get('Titre'));
        // $art->setDescription($request->get('description'));
        //  $art->setDate($request->get('date'));
        // $art->setVeterinaireId($request->get('veterinaire_id'));

        $Art->setDetails($request->get('Details'));

        $em->persist($Art);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Art);
        return new JsonResponse($formatted);

    }
    public function deleteArticleMobileAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $Art = $em->getRepository("PiAdminBundle:Article")->find($id);
        $em->remove($Art);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Art);
        return new JsonResponse($formatted);
    }
    public function updateAssuranceMobileAction(Request $request)
    {

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $art = $em->getRepository("PiAdminBundle:assurance")->find($id);

        $art->setNom($request->get('nom'));
        $art->setAdresse($request->get('adresse'));
        $art->setMail($request->get('mail'));
        $art->setDescription($request->get('description'));

        // $art->setAgeDeCeAnimal($request->get('ageDeCeAnimal'));
        //  $art->setTypeDeCeAnimal($request->get('typeDeCeAnimal'));

        $art->setPrixparanimaux($request->get('prixparanimaux'));

        $em->persist($art);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($art);
        return new JsonResponse($formatted);

    }
    public function deleteAssuranceMobileAction(Request $request){
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $Art = $em->getRepository("PiAdminBundle:assurance")->find($id);
        $em->remove($Art);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Art);
        return new JsonResponse($formatted);
    }

    public function calculerMobileAction(Request $request)
    {

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $assurancess = $em->getRepository("PiAdminBundle:assurance")->findOneBy(array('id' => $id));

        $nbanimaux = $request->get('nbanimaux');
        $prix = $assurancess->getPrixparanimaux();
        $tot = $nbanimaux * $prix;
        $assurancess->setTotalprix($tot);
        $em->persist($assurancess);
        $em->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);

        $formatted = $serializer->normalize($assurancess);

        //return $this->render("PiFrontBundle:Default:Assurances.html.twig", array('assurances' => $assurances, 'assurancess' => $assurancess));
        return new JsonResponse($formatted);
    }














}
