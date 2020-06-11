<?php

namespace App\Controller;
 use App\Entity\Offre;
 use App\Entity\Search;
use App\Form\SearchType;
use App\Form\OffreType;
use App\Repository\OffreRepository;
 use http\Client\Curl\User;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OffreController extends AbstractController
{
    /**
     * @Route("/offre", name="offre")
     */
    public function index()
    {
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }
     /**

     * @Route("/new", name="offre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $offre = new offre();
        $form = $this->createForm(OffreType::class, $offre );
        $form->handleRequest($request);
        $offre->setType('Essentiel');
        $offre->setUtilisateur($this->getUser());


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offre_new');
             $this->addFlash('message','offre passé avec succés ');
        }

        return $this->render('offre/offreES.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     *
     * @param OffreRepository $offre
     * @return \Symfony\Component\HttpFoundation\Response
     * @route ("/liste", name="Offre_ALL")
     */
public function show(OffreRepository $offrerep,Request $request ):Response
{
     $search =new Search();
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid()) {
            $term =$search->getName();

            $offre=$this->getDoctrine()->getRepository(Offre::class)->findBy(['societe' => $term] );
            
           
        } else
            $offre= $offrerep->findAll();

    
return $this->render ('offre/liste.html.twig',[
    'offres'=> $offre,
    'form'=>$form->createView()
]);
}

/**

     * @Route("/offre_Prime", name="offre_Prime", methods={"GET","POST"})
     */
    public function offrePR(Request $request): Response
    {
        $offre = new offre();
        $form = $this->createForm(OffreType::class, $offre );
        $form->handleRequest($request);
        $offre->setType('Prime');
        $offre->setUtilisateur($this->getUser());



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offre_Prime');
             $this->addFlash('message','offre passé avec succés ');

        }

        return $this->render('offre/offrePrime.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }
/**

     * @Route("/offre_Pro", name="offre_Pro", methods={"GET","POST"})
     */
    public function offrePRO(Request $request ): Response
    {
        $offre = new offre();
        $form = $this->createForm(OffreType::class, $offre );
        $form->handleRequest($request);
        $offre ->setType(' Pro');
        $offre->setUtilisateur($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offre_Pro');
                $this->addFlash('message','offre passé avec succés ');

        }

        return $this->render('offre/offrePro.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }



}
