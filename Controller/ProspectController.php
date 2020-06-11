<?php

namespace App\Controller;

use App\Entity\Search;
use App\Entity\User;
use App\Form\ContactProType;
use App\Form\ContactType;
use App\Form\SearchType;
use App\Repository\UserRepository;
use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Entity\Prospect;
use App\Form\ProspectType;
use App\Repository\ProspectRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Sensio\Bundle\FrameworkExtraBundle\{Configuration\ParamConverter,
    Configuration\Security,
    Configuration\IsGranted
};


/**
 * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
 * @Route("/prospect")
 */
class ProspectController extends AbstractController
{
    /** 
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @Route("/", name="prospect_index", methods={"GET","POST"})
     */
    public function index(ProspectRepository $prospectRepository,Request$request): Response
    {
        $search =new Search();
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()) {
            $term =$search->getName();

            $prospect=$this->getDoctrine()->getRepository(Prospect::class)->findBy(['company' => $term] );
            
           
        } else
            $prospect= $prospectRepository->findAll();




        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospect,
            'form'=>$form->createView()
        ]);
    }

    /**
      * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @Route("/new", name="prospect_new", methods={"GET","POST"})
     */
    public function new(Request $request , \Swift_Mailer $mailer): Response
    {
        $prospect = new Prospect();
        $form = $this->createForm(ProspectType::class, $prospect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
          
            $prospect->setUtilisateur($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prospect);
            $entityManager->flush();
// sending email standart
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom('sales-business@trustit.tn')
                // On attribue le destinataire
                ->setTo($prospect->getMail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'email/prospect.html.twig'
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);


            $this->addFlash('message','Prospect ajouté avec succés ');

            return $this->redirectToRoute('prospect_index');

        }

        return $this->render('prospect/new.html.twig', [
            'prospect' => $prospect,
            'form' => $form->createView(),
        ]);
    }

    /**
      * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @Route("show/{id}", name="prospect_show", methods={"GET"})
     */
    public function show(Prospect $prospect): Response
    {
        return $this->render('prospect/show.html.twig', [
            'prospect' => $prospect,
        ]);
    }

    /**
      * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @Route("/{id}/edit", name="prospect_edit",requirements={"id" = "\d+"}, methods={"GET","POST"})
     */
    public function edit(Request $request, Prospect $prospect): Response
    {
        $form = $this->createForm(ProspectType::class, $prospect);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                      $prospect->setUtilisateur($this->getUser());

            $this->getDoctrine()->getManager()->flush();
             $this->addFlash('message','Prospect modifié avec succés ');

            return $this->redirectToRoute('prospect_index');
        }

        return $this->render('prospect/edit.html.twig', [
            'prospect' => $prospect,
            'form' => $form->createView(),
        ]);
    }

    /**
      * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @Route("delete/{id}", name="prospect_delete", methods={"DELETE","POST","GET"},requirements={"id":"\d+"})
     */
    public function delete(Request $request, Prospect $prospect ): Response
    {
        if ($this->isCsrfTokenValid('delete.html.twig'.$prospect->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($prospect);
            $entityManager->flush();
        }

           $this->addFlash('message','Prospect bloqué  avec succés ');
        return $this->redirectToRoute('prospect_index');


        
    }





    /**
      * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @Route("convertir/{id}", name="convertir", methods={"GET","POST"})
     */
public function convertir (request $request ,prospect $prospect,\Swift_Mailer $mailer, UserPasswordEncoderInterface $passwordEncoder ):Response {

        

 $user= new User();

 $user -> setEmail( $prospect->getMail())
 // on génére la token d'activation
     ->setEnabled(true)
     ->setActivationToken(md5(uniqid()))
     -> setPassword ( $passwordEncoder->encodePassword($user,$prospect->getCompany().$prospect->getContactName()))
     ->setRoles((array)'ROLE_CLIENT')
     ->setCompanyName($prospect->getCompany())
     ->setResponsableName($prospect->getContactName());



    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($user);
    $entityManager->flush();

    $client= new Client();
        $client->setId($user->getId());
        $client ->setCompany($prospect->getCompany());
        $client ->setContactName($prospect ->getContactName());
        $client ->setContactPosition($prospect->getContactPosition());
        $client->setMail($prospect->getMail());
        $client->setAdresse($prospect->getAdresse());
        $client->setPhone($prospect->getPhone());
        $client->setType($prospect->getType());
        $client ->setUtilisateur($user);
      
       
        

        
   
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($client);
        $entityManager->flush();
    
   
    $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($prospect);
        $entityManager->flush();
                 // On crée le message
            $message = (new \Swift_Message('Activation du compte '))
                // On attribue l'expéditeur
                  ->setFrom('sales-business@trustit.tn')
                // On attribue le destinataire
                ->setTo($prospect->getmail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'email/ins.html.twig', ['email' => $user->getEmail(),
                          'password' => $prospect->getCompany().$prospect->getContactName(),
                          'responsable'=>$user ->getResponsableName(),
                           'token' => $user->getActivationToken(),
                        ]),
                    'text/html'
                )
            ;
            $mailer->send($message);


    $this->addFlash('message', 'Client crée avec succes');

    // On retourne à l'accueil
    return $this->redirectToRoute('prospect_index');
 

}
/*
 * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
*@Route ("/activation/{token}",name="activation")

*/

 public function activation ($token, UserRepository $user){
    // on verifier si lutilistaur  a ce token
    $user =$user->findOneBy(['activation_token' => $token]);

    // Si aucun utilisateur n'est associé à ce token
    if(!$user){
        // On renvoie une erreur 404
        throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
    }

    // On supprime le token
    $user->setActivationToken(null);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($user);
    $entityManager->flush();

    // On génère un message
    $this->addFlash('message', 'Utilisateur activé avec succès');

    // On retourne à l'accueil
    return $this->redirectToRoute('prospect_index');
}





    /**
    * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @Route("/contactProspect/{id}", name="contactP")
     * @param Request $request
     * @param \Swift_Mailer $mailer

     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function contact (request $request, \Swift_Mailer $mailer,Prospect $prospect)
    {  $form = $this->createForm(ContactProType::class);
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $contact =$form -> getData();

          //ici nous envoyons les emails
            $message=(new \Swift_Message($contact['sujet']))
            //on attribuer l'expediteur
            ->setFrom('ahlem.1998souid@gmail.com')

            //on attribuer le destinataire
             ->setTo($prospect->getMail())
            // on cree le message avec le vue twig
             ->setBody($contact['message'],
                    'text/plain'
             );
             //envoie de message
             $mailer->send($message);

             $this->addFlash('message','le message a bien été envoyé');
            return $this->redirectToRoute('prospect_index');

}
            return $this->render('contact/contactPro.html.twig', [
            'contactForm' => $form->createView() ,
        ]);
    }
/**
     * @Route("bloquerPro/{id}", name="prospect_Bloquer", methods={"GET","POST"})
     */
    public function bloquer (Request $request,Prospect $prospect ): Response
    {

            $em = $this->getDoctrine()->getManager();
            $prospect->setEtat(false);

            $em->flush();
            $this->addFlash('message', 'le Prospect Bloque avec succés');
        return $this->redirectToRoute('prospect_index');
    } 
/**
 * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
 * @Route("/Prospect/{id}", name="prospect_deBloquer", methods={"GET","POST"})
 */
    public function debloquer (Request $request,Prospect $prospect ): Response
    {

        $em = $this->getDoctrine()->getManager();
        $prospect->setEtat(true);

        $em->flush();
        $this->addFlash('message', 'le prospect déBloque avec succés');
        return $this->redirectToRoute('prospect_index');
    }
    /**
     * @Route("/deactiveProspect", name="prospect_debeloquer", methods={"GET","POST"})
     */
   public function listebloquer(ProspectRepository $prospectRepository,Request$request): Response
    {
        $search =new Search();
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()) {
            $term =$search->getName();

            $prospect=$this->getDoctrine()->getRepository(Prospect::class)->findBy(['company' => $term] );
            
           
        } else
            $prospect= $prospectRepository->findAll();




        return $this->render('prospect/listeDebloque.html.twig', [
            'prospects' => $prospect,
            'form'=>$form->createView()
        ]);
    }


}
