<?php

namespace App\Controller;

use App\Entity\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendrierController extends AbstractController
{
    /**
    * @IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @return Response
     * @Route("/calendrier", name="event_index")
     */
    public function index(){

        return $this->render('calendrier/calendar.html.twig');
    }
    /**
     * @return Response
     * @Route("/calendrierA", name="calendarA")
     */
    public function calendarB(){

        return $this->render('calendrier/calendarA.html.twig');
    }
    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_ROLE_RESPT"})
     * @return Response
     * @Route("/calendrierT", name="calendarT")
     */
    public function calendarT(){

        return $this->render('calendrier/calendarT.html.twig');
    }

    /**
     * @Route("/evenement-liste", name="evenement_liste")
     */
    public function liste()
    {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository(Event::class)->findBy(array('utilisateur' => $this->getUser()));
        $format = 'Y-m-d H:i:s';
        $data = [];
        foreach ($event as $row) {
            $data[] = array(
                'id' => $row->getId(),
                'title' => $row->getTitle(),
                'start' => $row->getstart()->format($format),
                'end' => $row->getEnd()->format($format),
            );
        }
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/evenement/ajouter", name="evenement_ajouter")
     */
    public function ajout(Request $request)
    {
        $format = 'Y-m-d H:i:s';
        $start = \DateTime::createFromFormat($format, $request->request->get('start'));
        $end = \DateTime::createFromFormat($format, $request->request->get('end'));

        $titre = $request->request->get('title');

        $event = new Event();
        $event->setTitle($titre);
        $event->setStart($start);
        $event->setEnd($end);
        $event->setUtilisateur($this->getUser());
        


        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        return new JsonResponse();
    }


    /**
     * @Route("/evenement/modifier", name="evenement_modifier")
     */
    public function modifier(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);

        $format = 'Y-m-d H:i:s';
        $start = \DateTime::createFromFormat($format, $request->request->get('start'));
        $end = \DateTime::createFromFormat($format, $request->request->get('end'));

        $titre = $request->request->get('title');
        $event->setTitle($titre);
        $event->setStart($start);
        $event->setEnd($end);
        $em->flush();

        return new JsonResponse();


    }

    /**
     * @Route("/evenement/supprimer", name="evenement_supprimer")
     */
    public function supprimer(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
//remove fonction predefinit pour supprimer
        $em->remove($event);
        $em->flush();

        return new JsonResponse();

    }


}
