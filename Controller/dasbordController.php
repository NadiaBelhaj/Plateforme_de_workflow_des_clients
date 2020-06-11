<?php

namespace App\Controller;

use App\Entity\Bloquer;
use App\Entity\Client;
use App\Entity\BloquerClient;
use App\Entity\Bloquerrep;
use App\Entity\Commande;
use App\Entity\Offre;
use App\Entity\Prospect;
use App\Entity\Reparateur;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class dasbordController extends AbstractController

{
    public function sommenrepatarteur()
    {// appel a l'entite
        $em = $this->getDoctrine()->getManager();
        // lien entre entity et la  base 
        $nb = $em->getRepository(Reparateur::class)->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.Etat = 1')
//Exécute la requête et retourne une seule valeur, et déclenche des exceptions si pas
//de résultat ou plus d'un résultat
            ->getQuery()->getSingleScalarResult();
        $em = $this->getDoctrine()->getManager();
        $nombre = $em->getRepository(Client::class)->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.id IS NOT NULL')
            ->getQuery()->getSingleScalarResult();
        $em = $this->getDoctrine()->getManager();
        $Total = $em->getRepository(Prospect::class)->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.etat = 1')
            ->getQuery()->getSingleScalarResult();


            $em = $this->getDoctrine()->getManager();
        $Totalpr = $em->getRepository(Prospect::class)->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.etat = 0')
            ->getQuery()->getSingleScalarResult();
              $em = $this->getDoctrine()->getManager();

        $Totalrep = $em->getRepository(Reparateur::class)->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.Etat = 0')
            ->getQuery()->getSingleScalarResult();
            $TotalC = $em->getRepository(Client::class)->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.Etat = 0')
            ->getQuery()->getSingleScalarResult();

        return $this->render('dashbord/dasbord.html.twig', [

            'nb' => $nb,
            'nombre' => $nombre,
            'Total' => $Total,
            'Totalpr'=>$Totalpr,
            'Totalrep'=>$Totalrep,
            'TotalC'=>$TotalC,
        ]);
    }

    /**
     * @IsGranted({"ROLE_ADMIN", "ROLE_RESPT"})
     * @Route("/tableaudebord", name="tableaudebord")
     */
    public function dasbord()
    {
        $em = $this->getDoctrine()->getManager();
        $countServices = $em->getRepository(Commande::class)->countByServcie();

// creation d'une charte 
        $pieChart = new PieChart();
        //recupération des données pour mettre dans la charte 
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Réparation et maintenace',     intval($countServices['type1'])],
                ['Achat matriéls informatiques',      intval($countServices['type2'])],
                ['Recyclage des Appareils',  intval($countServices['type3'])]
            ]
        );
        // style de la charte titre ,taille ; color.. 
        $pieChart->getOptions()->setTitle('Services');
        $pieChart->getOptions()->setHeight(300);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->setIs3D(true);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

// relation avec l'entity 
        $em = $this->getDoctrine()->getManager();
        //Un repository son role est la récupération des entités. 

        $countOffres = $em->getRepository(offre::class)->countByOffre();


        $chart = new PieChart();
        $chart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Essentiel',     intval($countOffres['type1'])],
                ['Prime',      intval($countOffres['type2'])],
                ['Pro',  intval($countOffres['type3'])]
            ]
        );
        $chart->getOptions()->setTitle('Offres');
        $chart->getOptions()->setHeight(300);
        $chart->getOptions()->setWidth(500);
        $chart->getOptions()->setIs3D(true);
        $chart->getOptions()->getTitleTextStyle()->setBold(true);
        $chart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $chart->getOptions()->getTitleTextStyle()->setItalic(true);
        $chart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $chart->getOptions()->getTitleTextStyle()->setFontSize(20);


 
  $em = $this->getDoctrine()->getManager();
        $countrep = $em->getRepository(Reparateur::class)->countrep();
        $chartRep = new PieChart();
        $chartRep->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Ordinateurs',     intval($countrep['type1'])],
                ['Smartphones',      intval($countrep['type2'])],
                ['tablettes ',  intval($countrep['type3'])],
                ['autres ',  intval($countrep['type4'])]
            ]
        );
        $chartRep->getOptions()->setTitle('Spécialités');
        $chartRep->getOptions()->setHeight(300);
        $chartRep->getOptions()->setWidth(500);
        $chartRep->getOptions()->setIs3D(true);
        $chartRep->getOptions()->getTitleTextStyle()->setBold(true);
        $chartRep->getOptions()->getTitleTextStyle()->setColor('#009900');
        $chartRep->getOptions()->getTitleTextStyle()->setItalic(true);
        $chartRep->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $chartRep->getOptions()->getTitleTextStyle()->setFontSize(20);




        return $this->render('dashbord/dashbordT.html.twig', array(
            'chart' => $chart,
            'piechart'=>$pieChart,
           'chartRep'=> $chartRep  

        ));
    }

    /**
     *@IsGranted({"ROLE_ADMIN", "ROLE_RESPB"})
     * @Route("/tableaudebordb", name="tableaudebordB")
     */
    public function dasbordb()
    {
     $em = $this->getDoctrine()->getManager();
        $countServices = $em->getRepository(Commande::class)->countByServcie();


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Réparation et maintenace',     intval($countServices['type1'])],
                ['Achat matriéls informatiques',      intval($countServices['type2'])],
                ['Recyclage des Appareils',  intval($countServices['type3'])]
            ]
        );
        $pieChart->getOptions()->setTitle('Services');
        $pieChart->getOptions()->setHeight(300);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->setIs3D(true);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        $em = $this->getDoctrine()->getManager();
        $countOffres = $em->getRepository(offre::class)->countByOffre();


        $chart = new PieChart();
        $chart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Essentiel',     intval($countOffres['type1'])],
                ['Prime',      intval($countOffres['type2'])],
                ['Pro',  intval($countOffres['type3'])]
            ]
        );
        $chart->getOptions()->setTitle('Offres');
        $chart->getOptions()->setHeight(300);
        $chart->getOptions()->setWidth(500);
        $chart->getOptions()->setIs3D(true);
        $chart->getOptions()->getTitleTextStyle()->setBold(true);
        $chart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $chart->getOptions()->getTitleTextStyle()->setItalic(true);
        $chart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $chart->getOptions()->getTitleTextStyle()->setFontSize(20);


 
  $em = $this->getDoctrine()->getManager();
        $countrep = $em->getRepository(Reparateur::class)->countrep();
        $chartRep = new PieChart();
        $chartRep->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Ordinateurs',     intval($countrep['type1'])],
                ['Smartphones',      intval($countrep['type2'])],
                ['tablettes ',  intval($countrep['type3'])],
                ['autres ',  intval($countrep['type4'])]
            ]
        );
        $chartRep->getOptions()->setTitle('Spécialités');
        $chartRep->getOptions()->setHeight(300);
        $chartRep->getOptions()->setWidth(500);
        $chartRep->getOptions()->setIs3D(true);
        $chartRep->getOptions()->getTitleTextStyle()->setBold(true);
        $chartRep->getOptions()->getTitleTextStyle()->setColor('#009900');
        $chartRep->getOptions()->getTitleTextStyle()->setItalic(true);
        $chartRep->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $chartRep->getOptions()->getTitleTextStyle()->setFontSize(20);




        return $this->render('dashbord/dashbordB.html.twig', array(
            'chart' => $chart,
            'piechart'=>$pieChart,
           'chartRep'=> $chartRep  

        ));
    
        
    }

    /**
     * @Route("/tableaudebordA", name="tableaudebordA")
     */
    public function dasbordA()
    {
 $em = $this->getDoctrine()->getManager();
        $countServices = $em->getRepository(Commande::class)->countByServcie();


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Réparation et maintenace',     intval($countServices['type1'])],
                ['Achat matriéls informatiques',      intval($countServices['type2'])],
                ['Recyclage des Appareils',  intval($countServices['type3'])]
            ]
        );
        $pieChart->getOptions()->setTitle('Services');
        $pieChart->getOptions()->setHeight(300);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->setIs3D(true);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        $em = $this->getDoctrine()->getManager();
        $countOffres = $em->getRepository(offre::class)->countByOffre();


        $chart = new PieChart();
        $chart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Essentiel',     intval($countOffres['type1'])],
                ['Prime',      intval($countOffres['type2'])],
                ['Pro',  intval($countOffres['type3'])]
            ]
        );
        $chart->getOptions()->setTitle('Offres');
        $chart->getOptions()->setHeight(300);
        $chart->getOptions()->setWidth(500);
        $chart->getOptions()->setIs3D(true);
        $chart->getOptions()->getTitleTextStyle()->setBold(true);
        $chart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $chart->getOptions()->getTitleTextStyle()->setItalic(true);
        $chart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $chart->getOptions()->getTitleTextStyle()->setFontSize(20);


 
  $em = $this->getDoctrine()->getManager();
        $countrep = $em->getRepository(Reparateur::class)->countrep();
        $chartRep = new PieChart();
        $chartRep->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Ordinateurs',     intval($countrep['type1'])],
                ['Smartphones',      intval($countrep['type2'])],
                ['tablettes ',  intval($countrep['type3'])],
                ['autres ',  intval($countrep['type4'])]
            ]
        );
        $chartRep->getOptions()->setTitle('Spécialités');
        $chartRep->getOptions()->setHeight(300);
        $chartRep->getOptions()->setWidth(500);
        $chartRep->getOptions()->setIs3D(true);
        $chartRep->getOptions()->getTitleTextStyle()->setBold(true);
        $chartRep->getOptions()->getTitleTextStyle()->setColor('#009900');
        $chartRep->getOptions()->getTitleTextStyle()->setItalic(true);
        $chartRep->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $chartRep->getOptions()->getTitleTextStyle()->setFontSize(20);




        return $this->render('dashbord/dashbordA.html.twig', array(
            'chart' => $chart,
            'piechart'=>$pieChart,
           'chartRep'=> $chartRep  

        ));
       }
}