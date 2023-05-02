<?php

namespace App\Controller;

use App\AbstractClass\FactureStatusValues;
use App\Entity\FactureFournisseur;
use App\Services\StatsServices;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{

    #[Route('/stats', name: 'stats')]
    public function index(StatsServices $services){

        list($values,$labels) = $services->getAllFactureWithLastStatus();
        $options = $services->prepareJsonChart($labels,$values,"Statistiques");
        list($labels,$values) = $services->getTopFournisseur();
        $stats2 = $services->prepareJsonChart($labels,$values,"Top 10 Fournisseurs");
        return $this->render('Stats/stats.html.twig', ['stats1'=> json_encode($options), 'stats2' => json_encode($stats2)]);
    }

}