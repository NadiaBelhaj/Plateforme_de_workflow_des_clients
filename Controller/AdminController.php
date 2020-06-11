<?php

namespace App\Controller;

use App\Entity\BloquerUser;
use App\Entity\Client;
use App\Entity\Search;
use App\Entity\User;
use App\Form\ContactProType;
use App\Form\EditUserType;
use App\Form\SearchType;
use App\Form\User1Type;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use http\Message;
use phpDocumentor\Reflection\Type;
use PhpParser\Node\Stmt\Finally_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
//Ajouter Response
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class AdminController extends AbstractController
{
   

    /**
     *list des utilisateurs du site
     *
     * @param UserRepository $users
     * @return \Symfony\Component\HttpFoundation\Response
     * @route ("admin/utilisateurs", name="utilisateurs")
     */
    public function userslist(UserRepository $users, Request $request)
    {

        $search = new Search();
        // creation d'une formulaire de recherche
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //reçoit le terme a chercher 
            $term = $search->getName();
//Un repository son role est la récupération des entités. 
// faire la recherche avec findBy fonction predefini
            $users = $this->getDoctrine()->getRepository(User::class)->findBy(['companyName' => $term]);
            

        } else
            $users = $this->getDoctrine()->getRepository(User::class)->findAll();


        return $this->render('admin/users.html.twig', [
            'form' => $form->createView(),
            // On passe la méthode createView() du formulaire//à la vue afin qu'elle puisse afficher le formulaire
            'users' => $users,
        ]);


    }

    /**
     *
     * @Route("/utilisateur/modifier/{id}", name="edit_user", methods={"GET","POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    //Vous avez alors accès à la requête HTTP via $request.
    public function edit(User $users, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // pour faire une relation avec entity 
            $this->getDoctrine()->getManager();

// Les repositories utilisent en réalité directement l'EntityManager pour faire leur
//travail. Vous le verrez, parfois nous ferons directement appel à
//l'EntityManager depuis des méthodes du repository.
            $em = $this->getDoctrine()->getManager();
            //declenche l action de modification 
            $em->persist($users);
            //force la modifiction dans la  base 
            $em->flush();
//message d'affichage 
            $this->addFlash('message', 'Utilisateurs modifié avec succés');
//La méthode redirectToRoute prend directement en argument l nom de la 
//route vers laquelle rediriger, et non l'URL.
            return $this->redirectToRoute('utilisateurs');
        }

        return $this->render('admin/edit.html.twig', [
            'user' => $users,
             // On passe la méthode createView() du formulaire//à la vue afin qu'elle puisse afficher le formulaire
            'userform' => $form->createView(),
        ]);
    }

  


    /**
     *
     * @Route("/utilisateur/{id}", name="show_user", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/profil.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     *
     * @Route("/profiluser/{id}", name="profil_user", methods={"GET"})
     */
    public function profil(User $user): Response
    {
        return $this->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     *
     * @Route("/profil/modifier/{id}", name="edit_profil", methods={"GET","POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function modifier(User $users, Request $request)
    {
        $form = $this->createForm(User1Type::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager();


            $em = $this->getDoctrine()->getManager();
            $em->persist($users);
            $em->flush();

            $this->addFlash('message', 'profil modifié avec succés');

            return $this->redirectToRoute('espaceclient');
        }

        return $this->render('profil/edit.html.twig', [
            'user' => $users,
            'form' => $form->createView(),
        ]);
    }
    
    

/**
     *
     * @Route("/contact/{id}", name="conatctAd")
     * @param Request $request
     * @param \Swift_Mailer $mailer

     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function contact (request $request, \Swift_Mailer $mailer,User $user)
    //creation dela formulaire decontact 
    {  $form = $this->createForm(ContactProType::class);
        // On fait le lien Requête <-> Formulaire
// À partir de maintenant, la variable $form
//contient les valeurs entrées dans le formulaire
        $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $contact =$form -> getData();

          //ici nous envoyons les emails
            $message=(new \Swift_Message($contact['sujet']))
            //on attribuer l'expediteur
            ->setFrom('ahlem.1998souid@gmail.com')

            //on attribuer le destinataire
             ->setTo($user->getEmail())
            // on cree le message avec le vue twig
             ->setBody($contact['message'],
                    'text/plain'
             );
             //envoie de message
             $mailer->send($message);

             $this->addFlash('message','le message a bien été envoyé');
            return $this->redirectToRoute('utilisateurs');

}
            return $this->render('contact/contact.html.twig', [
            'contactForm' => $form->createView() ,
        ]);
    }

 /**
     *
     * @Route("/bloquser/{id}", name="bloqUser", methods={"GET","POST"})
     */
    public function bloquer(user $user, \Swift_Mailer $mailer): Response
    //appel a la entity 
    { $em = $this->getDoctrine()->getManager();
          //mettre l'utilisteurs non-active
         $user->setEnabled(false);
         //renforce la modifiaction dans la base 
         $em->flush();
         $this->addFlash('message','User Bloque avec succés');
           // sending email standart
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom('sales-business@trustit.tn')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'email/prospect.html.twig'
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
    return $this->redirectToRoute('utilisateurs');
    
    }

/**
     *
     * @Route("/debloquser/{id}", name="debloqUser", methods={"GET","POST"})
     */
    public function debloquer(user $user, \Swift_Mailer $mailer ): Response
{ //appel a la entity 
    $em = $this->getDoctrine()->getManager();
    //mettre l'utilisteurs active 
         $user->setEnabled(true);
         //renforce la modifiaction dans la base 
         $em->flush();
         $this->addFlash('message','User Débloque avec succés');
           // sending email standart
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom('sales-business@trustit.tn')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'email/prospect.html.twig'
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
    return $this->redirectToRoute('utilisateurs');
    
    }








}