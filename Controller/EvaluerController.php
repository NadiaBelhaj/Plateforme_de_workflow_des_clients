<?php


namespace App\Controller;
use App\Entity\Rating;
use App\Repository\RatingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EvaluerController extends AbstractController
{
    /**
     * @IsGranted({"ROLE_ADMIN"})
     * @Route("/rating", name="rating")
     */
    public function rating(RatingRepository $rating )
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


        return $this->render('rating/index.html.twig', [
            'rating' => $rating->findAll(), // retour dauns un tableau les donneé
            'nombreEvaluation' => $nombreEvaluation, // pour recuperer les données dans la vue twig
            'nombreEtoile' => $nombreEtoiles

        ]);
    }

}