<?php
/**
 * Created by PhpStorm.
 * User: abdelaziz
 * Date: 21/02/2018
 * Time: 10:56
 */

namespace Pi\FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ContactUsController extends Controller
{
    public function ContactUsAction(Request $request)
    { $form = $this->createFormBuilder()
        ->add('from', EmailType::class)
        ->add('message', TextareaType::class)
        ->add('send', SubmitType::class)
        ->getForm()
    ;

        $form->handleRequest($request); // the new line

        if ($form->isSubmitted() && $form->isValid()) {
            $Data = $form->getData();
             dump($Data);
            $message = \Swift_Message:: newInstance()
                ->setSubject('Contact Form Submission')
                ->setFrom($Data['from'])
                ->setTo('zanimaux.pi@gmail.com')
                ->setBody(
                    $form->getData()['message'],
                    'text/plain'
                )
            ;

            $this->get('mailer')->send($message);
            return $this->render('PiFrontBundle:Default:EmailRecu.html.twig');
        }

        return $this->render('PiFrontBundle:Default:ContactUs.html.twig', [
            'form' => $form->createView(),
        ]);


    }

}