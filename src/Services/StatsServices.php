<?php

namespace App\Services;

use App\AbstractClass\FactureStatusValues;
use App\Entity\FactureFournisseur;
use App\Entity\Fournisseur;
use Doctrine\ORM\EntityManagerInterface;

class StatsServices
{


    public function __construct(protected FactureFournisseurServices $factureFournisseurServices, public EntityManagerInterface $entityManager)
    {
    }

    public function prepareJsonChart(array $labels, array $values,String $title)
    {
       return
           array(
            'type' => 'bar',
            'data' => array(
                'labels' => $labels,
                'datasets' => array(
                    array(
                        'label' => $title,
                        'backgroundColor' => '#007bff',
                        'data' => $values,
                        'backgroundColor' => array(
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'),
                        'borderColor' => array(
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'),
                        'borderWidth'=> 1
                    ),
                )
            )
        );
    }

    public function getAllFactureWithLastStatus(){

        $allFacture = $this->entityManager->getRepository(FactureFournisseur::class)->findAll();
        $values = array(0,0,0,0,0,0);
        foreach ($allFacture as $facture) {
            $status = $this->factureFournisseurServices->getLastWorkflowPaiementsStatusForFacture($facture);
            if(!empty($status)) {
                $values[$status]++;
            }else{
                $values[0]++;
            }
        }

        return [$values,FactureStatusValues::$statusLabel];
    }

    public function getTopFournisseur(){
        $allFournissuer = $this->entityManager->getRepository(FactureFournisseur::class)->findTopFournisseur();

        foreach ($allFournissuer as $element){
            $labels[] = $element['raisonSociale'];
            $values[] = $element['factures'];
        }

        return [$labels,$values];
    }

}