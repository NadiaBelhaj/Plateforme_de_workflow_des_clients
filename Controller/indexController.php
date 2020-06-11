<?php


namespace App\Controller;

use App\Entity\Rating;
use App\Repository\RatingRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Psr\Log\LoggerInterface;

class indexController extends AbstractController
{
    /**
     * @route ("index")
     */
    public function index()
    {
        return $this->render('view/client.html.twig');
    }

    /**
    * @IsGranted({"ROLE_ADMIN", "ROLE_CLIENT"})
     * @route ("/espaceclient",name="espaceclient")
     */
    public function espace()
    {// appel a l'entite 
        $em = $this->getDoctrine()->getManager();
//Un repository son role est la récupération des entités. 
        $nombreEvaluation = $em->getRepository('App:Rating')->nombreRating();
        $sumEvaluation = $em->getRepository('App:Rating')->sumRating();
// calcule de nobre d'evaluation effectuer et la moyenne d'evaluation
        $nombreEtoiles = 0;
        if ($nombreEvaluation > 0 && $sumEvaluation > 0) {
            $nombreEtoiles = intval($sumEvaluation / $nombreEvaluation);
        }
// affichage en  twig 
        return $this->render('view/espaceclient.html.twig', array(
            'nombreEvaluation' => $nombreEvaluation,
            'nombreEtoile' => $nombreEtoiles
        ));
    }


    /**
     * @Route("/evaluation-new", name="evaluer")
     */
    public function evaluer(Request $request)
    { // appel a l'entite 
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {

            $nombre = $request->request->get('rating');
            // cration d'un vouveau rating
            $rating = new Rating();
            $rating->setNumber($nombre);
            $rating->setUtilisateur($this->getUser());
            $em->persist($rating);
            $em->flush();
//Un repository son role est la récupération des entités. 

            $nombreEvaluation = $em->getRepository('App:Rating')->nombreRating();
            $sumEvaluation = $em->getRepository('App:Rating')->sumRating();
// calcule de nobre d'evaluation effectuer et la moyenne d'evaluation
            $nombreEtoiles = 0;
            if ($nombreEvaluation > 0 && $sumEvaluation > 0) {
                $nombreEtoiles = intval($sumEvaluation / $nombreEvaluation);
            }
//reponse en jason afin d'utiliser les chiffres dans une fonction ajax 
            return new JsonResponse(array(
                'nombreEvaluation' => $nombreEvaluation,
                'nombreEtoile' => $nombreEtoiles
            ));
        }
    }
 


}


