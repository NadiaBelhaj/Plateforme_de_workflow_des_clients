<?php

namespace App\Controller;

use App\Form\Contact;
use App\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SwiftmailerBundle\Command\SendEmailCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\TokenParser\SetTokenParser;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;



class ContactController extends AbstractController
{
    /**
     * @IsGranted({"ROLE_CLIENT"})
     * @Route("/contact", name="contact")
     */
    public function index(request $request,\Swift_Mailer $mailer)
    {  $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
         	$contact =$form -> getData();

          //ici nous envoyons les emails
         	$message=(new \Swift_Message($contact['sujet']))
         	//on attribuer l'expediteur
         	->setFrom($contact['email'])

            //on attribuer le destinataire
             ->setTo('ahlem.1998souid@gmail.com')
         	// on cree le message avec le vue twig
             ->setBody($contact['message'],
                    'text/plain'
             );
             //envoie de message
             $mailer->send($message);

             $this->addFlash('message','le message a bien été envoyé');
             return $this->redirectToRoute('contact');

}
            return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView() ,
        ]);
    }


 /**
     *
     * @Route("/contactAD", name="contactAD")
     */
    public function Contact(request $request,\Swift_Mailer $mailer)
    {  $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $contact =$form -> getData();

          //ici nous envoyons les emails
            $message=(new \Swift_Message($contact['sujet']))
            //on attribuer l'expediteur
            ->setFrom($contact['email'])

            //on attribuer le destinataire
             ->setTo('ahlem.1998souid@gmail.com')
            // on cree le message avec le vue twig
             ->setBody($contact['message'],
                    'text/plain'
             );
             //envoie de message
             $mailer->send($message);

             $this->addFlash('message','le message a bien été envoyé');
return $this->redirectToRoute('contactAD');

}
            return $this->render('contact/contactAd.html.twig', [
            'contactForm' => $form->createView() ,
        ]);


}






/**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/contactT", name="contactT")
     */
    public function ContactT(request $request,\Swift_Mailer $mailer)
    {  $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $contact =$form -> getData();

          //ici nous envoyons les emails
            $message=(new \Swift_Message($contact['sujet']))
            //on attribuer l'expediteur
            ->setFrom($contact['email'])

            //on attribuer le destinataire
             ->setTo('ahlem.1998souid@gmail.com')
            // on cree le message avec le vue twig
             ->setBody($contact['message'],
                    'text/plain'
             );
             //envoie de message
             $mailer->send($message);

             $this->addFlash('message','le message a bien été envoyé');
return $this->redirectToRoute('contactT');

}
            return $this->render('contact/contactb.html.twig', [
            'contactForm' => $form->createView() ,
        ]);


}

}
