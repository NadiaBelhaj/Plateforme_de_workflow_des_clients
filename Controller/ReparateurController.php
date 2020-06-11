<?php

namespace App\Controller;

use App\Entity\BloquerReparateur;
use App\Entity\Bloquerrep;
use App\Entity\Search;
use App\Form\ContactProType;
use App\Form\SearchType;
use App\Entity\Reparateur;
use App\Form\ReparateurType;
use App\Repository\ReparateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
  * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
 * @Route("/reparateur")
 */
class ReparateurController extends AbstractController
{
    /**
     *@IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/", name="reparateur_index", methods={"GET","POST"})
     */
    public function index(ReparateurRepository $reparateurRepository, Request $request): Response
    {

// cration d'un recherche 
        $search = new Search();
        //creation d'une barre de recherche 
        $form = $this->createForm(SearchType::class, $search);
        // On fait le lien Requête <-> Formulaire
// À partir de maintenant, la variable $search
//contient les valeurs entrées dans le formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $term = $search->getName();

            $reparateur = $this->getDoctrine()->getRepository(Reparateur::class)->findBy(['Nom' => $term]);


        } else
            $reparateur = $reparateurRepository->findAll();

        return $this->render('reparateur/index.html.twig', [
            'reparateurs' => $reparateur,
             // On passe la méthode createView() du formulaire//à la vue afin qu'elle puisse afficher le formulaire
            'form_search' => $form->createView()
        ]);
    }

    /**
     *@IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/new", name="reparateur_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {  // creation d'nouveau reparateur 
        $reparateur = new Reparateur();
        // creation d'une formulaire de recherche
        $form = $this->createForm(ReparateurType::class, $reparateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
// relation avec l'entity 
            $entityManager = $this->getDoctrine()->getManager();
            //declenche laction de lajout
            $entityManager->persist($reparateur);
            //renforce l'ajout dans la base
            $entityManager->flush();
            $this->addFlash('message', 'Réparateur ajouté avec succés ');

            return $this->redirectToRoute('reparateur_index');
        }

        return $this->render('reparateur/new.html.twig', [
            'reparateur' => $reparateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("show/{id}", name="reparateur_show", methods={"GET"})
     */
    public function show(Reparateur $reparateur): Response
    {
        return $this->render('reparateur/show.html.twig', [
            'reparateur' => $reparateur,
        ]);
    }

    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/{id}/edit", name="reparateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reparateur $reparateur): Response
    {
        $form = $this->createForm(ReparateurType::class, $reparateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('message', 'Réparateur modifié avec succés ');

            return $this->redirectToRoute('reparateur_index');
        }

        return $this->render('reparateur/edit.html.twig', [
            'reparateur' => $reparateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/{id}", name="reparateur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reparateur $reparateur): Response
    {
        if ($this->isCsrfTokenValid('delete.html.twig' . $reparateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reparateur);
            $entityManager->flush();
        }


        return $this->redirectToRoute('reparateur_index');
    }

    /**
     *@IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/contactReparateur/{id}", name="contactR")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function contact(request $request, \Swift_Mailer $mailer, Reparateur $reparateur)
    {
        $form = $this->createForm(ContactProType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            //ici nous envoyons les emails
            $message = (new \Swift_Message($contact['sujet']))
                //on attribuer l'expediteur
                ->setFrom('ahlem.1998souid@gmail.com')

                //on attribuer le destinataire
                ->setTo($reparateur->getEmail())
                // on cree le message avec le vue twig
                ->setBody($contact['message'],
                    'text/plain'
                );
            //envoie de message
            $mailer->send($message);

            $this->addFlash('message', 'le message a bien été envoyé');
            return $this->redirectToRoute('reparateur_index');

        }
        return $this->render('contact/contactb.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("bloquer/{id}", name="reparateur_Bloquer", methods={"GET","POST"})
     */
    public function bloquer (Request $request, Reparateur $reparateur): Response
    {

            $em = $this->getDoctrine()->getManager();
            $reparateur->setEtat(false);

            $em->flush();
            $this->addFlash('message', 'le reaparetur Bloque avec succés');
        return $this->redirectToRoute('reparateur_index');
    } /**
 * @Route("/debloquer/{id}", name="reparateur_deBloquer", methods={"GET","POST"})
 */
    public function debloquer (Request $request, Reparateur $reparateur): Response
    {

        $em = $this->getDoctrine()->getManager();
        $reparateur->setEtat(true);

        $em->flush();
        $this->addFlash('message', 'le reaparetur Bloque avec succés');
        return $this->redirectToRoute('reparateur_index');
    }
    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/debloquerrep", name="reparateur_deboloquer", methods={"GET","POST"})
     */
    public function listedebloquer(ReparateurRepository $reparateurRepository, Request $request): Response
    {


        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $term = $search->getName();

            $reparateur = $this->getDoctrine()->getRepository(Reparateur::class)->findBy(['Nom' => $term]);


        } else
            $reparateur = $reparateurRepository->findAll();

        return $this->render('reparateur/repdebloqué.html.twig', [
            'reparateurs' => $reparateur,
            'form_search' => $form->createView()
        ]);
    }
}

