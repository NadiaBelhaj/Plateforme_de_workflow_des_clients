<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    public function notificationHeader(){
    // appel al'entity 
        $em = $this->getDoctrine()->getManager();
        //on met la relation entre l'entit et la base 
        // retourne le nombre de notification non lue 
        $nbNotifNonLus = $em->getRepository(Notification::class)->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.vu = 0')
            // retour une seul resultat
            ->getQuery()->getSingleScalarResult();
// rendre les dernier notifiction 
        $derniersNotifs = $em->getRepository(Notification::class)->findBy(array(), array('id'=> 'desc'), 10, 0);
        return $this->render('notification/in_header.html.twig', array(
            'nbNotifNonLus'=>$nbNotifNonLus,// pour l affiche dans la vue (twig)
            'derniersNotifs'=> $derniersNotifs
        ));
    }
    /**
     * @Route("/notification/liste", name="notification_liste")
     */
    public function liste()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/notification/voir/{id}", name="notification_voir")
     */
    public function voir(Notification $notification)
    {
      $em = $this->getDoctrine()->getManager();
      $notification->setVu(true);
      $em->flush();

     //return $this->redirectToRoute('commande_show', array('id'=> $notification->getCommande()->getId()));
      return $this->redirectToRoute('commande');
    }


}