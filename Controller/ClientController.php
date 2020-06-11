<?php

namespace App\Controller;
use App\Entity\Search ;
use App\Entity\User;

use App\Entity\BloquerClient;
use App\Entity\Client;

use App\Form\ClientType;
use App\Form\ContactProType;
use App\Form\SearchType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Prospect;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
* @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    
     /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/", name="client_index", methods={"GET","POST"})
     */
    public function index(ClientRepository $clientRepository ,Request $request ): Response
    {
        $search =new Search();
        $form = $this->createForm(SearchType::class,$search);
         // creation d'une formulaire de recherche
        $form->handleRequest($request);
        // On fait le lien Requête <-> Formulaire
// À partir de maintenant, la variable $search
//contient les valeurs entrées dans le formulaire
        if ( $form->isSubmitted() && $form->isValid()) {
            //reçoit le terme a chercher 
            $term = $search->getName();
//Un repository son role est la récupération des entités. 
// faire la recherche avec findBy fonction predefini
            $client=$this->getDoctrine()->getRepository(Client::class)->findBy(['company' => $term]);

        } else
            $client= $this->getDoctrine()->getRepository(Client::class)->findAll();


return $this->render('client/index.html.twig',[
            'form' => $form->createView(),
            // On passe la méthode createView() du formulaire//à la vue afin qu'elle puisse afficher le formulaire
            'clients'=> $client

        ]);
    }



    /**
    * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    { // creation d'une nouveau client 
        $client = new Client();
        //creation d'un nouveau formulaire
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
// On fait le lien Requête <-> Formulaire
// À partir de maintenant, la variable $client
//contient les valeurs entrées dans le formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // craetion d'nouveau utilisteur
            $user= new User();
            $user -> setEmail( $client->getMail())
                // on génére la token d'activation
                ->setActivationToken(md5(uniqid()))
                -> setPassword ( $passwordEncoder->encodePassword($user,$client->getCompany().$client->getContactName()))
                ->setRoles((array)'ROLE_CLIENT')
                ->setCompanyName($client->getCompany())
                ->setEnabled(false)
                ->setResponsableName($client->getContactName());
// appel a lentity 
            $entityManager = $this->getDoctrine()->getManager();
            //declenche l'action 
            $entityManager->persist($user);
            //force la modifiction dans la  base 
            $entityManager->flush();
           $client ->setUtilisateur($user);
           // relation avec l'entie
            $entityManager = $this->getDoctrine()->getManager();
            // declenche laction
            $entityManager->persist($client);
            // renfoece la modification dans la base 
            $entityManager->flush();
            return $this->redirectToRoute('client_index');
             $this->addFlash('message','Client ajouté avec succés ');

        }



        return $this->render('client/new.html.twig', [
            'client' => $client,
             // On passe la méthode createView() du formulaire//à la vue afin qu'elle puisse afficher le formulaire
            'form' => $form->createView(),
        ]);
    }

    /**
    * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("client/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {// creation de la formulaire
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index');
            $this->addFlash('message','Client modifié avec succés ');

        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
    * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @param Request $request
     * @Route("delete/{id}", name="client_delete", methods={"DELETE","GET","POST"})
     */
    public function delete(Request $request, Client $client ): Response
    {
        if ($this->isCsrfTokenValid('delete.html.twig'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

       
        return $this->redirectToRoute('client_index');
    }

    /**
     ** @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/contactClient/{id}", name="contactC")
     * @param Request $request
     * @param \Swift_Mailer $mailer

     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function contact (request $request, \Swift_Mailer $mailer,Client $client)
    {  $form = $this->createForm(ContactProType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact =$form -> getData();

            //ici nous envoyons les emails
            $message=(new \Swift_Message($contact['sujet']))
                //on attribuer l'expediteur
                ->setFrom('ahlem.1998souid@gmail.com')

                //on attribuer le destinataire
                ->setTo($client->getMail())
                // on cree le message avec le vue twig
                ->setBody($contact['message'],
                    'text/plain'
                );
            //envoie de message
            $mailer->send($message);

            $this->addFlash('message','le message a bien été envoyé');
            return $this->redirectToRoute('client_index');

        }
        return $this->render('contact/contactT.html.twig', [
            'contactForm' => $form->createView() ,
        ]);
    }

  /**
  * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("bloquerc/{id}", name="client_Bloquer", methods={"GET","POST"})
     */
    public function bloquer (Request $request,Client $client  ): Response
    {
//appel a l'entite
            $em = $this->getDoctrine()->getManager();
            // bloque le client
            $client->setEtat(false);
//renforce la modfiction dans la base
            $em->flush();
            // message 
            $this->addFlash('message', 'le client Bloque avec succés');
            //redirection 
        return $this->redirectToRoute('client_index');
    }




     /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
 * @Route("/client/{id}", name="client_deBloquer", methods={"GET","POST"})
 */
    public function debloquerclient (Request $request,Client $client ): Response
    {

        $em = $this->getDoctrine()->getManager();
        $client->setEtat(true);

        $em->flush();
        $this->addFlash('message', 'le client Bloque avec succés');
        return $this->redirectToRoute('client_index');
    }
    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/desactiveclient", name="bloquer_client_index", methods={"GET","POST"})
     */
   public function listebloquer(ClientRepository $clientRepository,Request$request): Response
    {
        $search =new Search();
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()) {
            $term =$search->getName();

            $client=$this->getDoctrine()->getRepository(Client::class)->findBy(['company' => $term] );
            
           
        } else
            $client= $clientRepository->findAll();




        return $this->render('client/listeDebloque.html.twig', [
            'clients' => $client,
            'form'=>$form->createView()
        ]);
    }


    



}