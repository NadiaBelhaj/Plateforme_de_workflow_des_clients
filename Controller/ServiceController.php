<?php

namespace App\Controller;

use App\Entity\Categoryservice;
use App\Entity\Commande;
use App\Entity\Notification;
use App\Form\Commande2Type;
use App\Form\CommandeType;
use App\Form\ServiceType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="commande")
     */
    public function index(CommandeRepository $CommandeRepository)
    {
       // affiche de tableau des service passeés
        return $this->render('service/index.html.twig', [
            'commandes' => $CommandeRepository->findAll(),
       

        ]);
    }

  /**
     * @Route("service/{id}", name="commande_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('service/show.html.twig', [
            'commande' => $commande,
        ]);
    }
 /**
     *
      * @IsGranted({"ROLE_ADMIN", "ROLE_CLIENT"})
     * @Route("/commande/Repartion&maintenace", name="Repartion&maintenace", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {// craetion d'une nouvelle commande 
        $commande = new commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             

            $commande->setUtilisateur($this->getUser());
            $commande->setType('Repartion&maintenace');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();
// creation d'u notifiction 
            $notif= new Notification ();
            $notif->setCommande($commande);
            $entityManager->persist($notif);
            $entityManager->flush();
            return $this->redirectToRoute('espaceclient');
        }

        return $this->render('service/commande1.html.twig', [
          
            'form' => $form->createView(),

        ]);
    }

     /**
     *
      * @IsGranted({"ROLE_ADMIN", "ROLE_CLIENT"})
      * @IsGranted({"ROLE_ADMIN", "ROLE_CLIENT"}) * @IsGranted({"ROLE_ADMIN", "ROLE_CLIENT"})
     * @Route("/commande/Achat matriel informatique", name="Achat matriel informatique", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $commande = new commande();
        $form = $this->createForm(Commande2Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setUtilisateur($this->getUser());
            $commande->setType('Achat matriel informatique');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();
            $notif= new Notification ();
            $notif->setCommande($commande);
            $entityManager->persist($notif);
            $entityManager->flush();

            return $this->redirectToRoute('espaceclient');
        }

        return $this->render('service/commande2.html.twig', [
          
            'form' => $form->createView(),

        ]);
    }

    /**
     *
      * @IsGranted({"ROLE_ADMIN", "ROLE_CLIENT"})
     * @Route("/commande/Recyclage des Appareils", name="Recyclage des Appareils", methods={"GET","POST"})
     */
    public function  Commande(Request $request): Response
    {
        $commande = new commande();
        $form = $this->createForm(Commande2Type::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commande->setUtilisateur($this->getUser());
            $commande->setType('Recyclage des Appareils');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();
            $notif= new Notification ();
            $notif->setCommande($commande);
            $entityManager->persist($notif);
            $entityManager->flush();
            return $this->redirectToRoute('espaceclient');
        }

        return $this->render('service/commande2.html.twig', [

            'form' => $form->createView(),

        ]);
    }

 /**
     * @Route("/s", name="service")
     */
    public function service(Request $request)
    {
      $service = new Categoryservice();
        $form = $this->createForm(ServiceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($term = $service->getServiceName())
             {
             $client=$this->getDoctrine()->getRepository(Categoryservice::class)->findBy(['service_name' => $term]);
                return $this->redirectToRoute('Recyclage des Appareils');}
        }



        return $this->render('view/service.html.twig', [

            'form' => $form->createView(),

        ]);
    }
}
?>