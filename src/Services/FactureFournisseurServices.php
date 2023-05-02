<?php
namespace App\Services;


use App\Entity\FactureFournisseur;
use App\Entity\Service;
use App\Entity\WorkflowPaiements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class FactureFournisseurServices
{

    public function __construct(public EntityManagerInterface $entityManager, protected Security $security)
    {
    }

    public function addWorkFlow(FactureFournisseur $facture, Service $service, int $status):bool
    {
        $workFlow = new WorkflowPaiements();
        $workFlow->setFactureFournisseur($facture);
        $workFlow->setStatut($status);
        $workFlow->setService($service);
        $workFlow->setDateEmission(new \DateTimeImmutable());
        $this->entityManager->persist($workFlow);
        $this->entityManager->flush();
        return true;
    }

    public function getLastWorkflowPaiementsStatusForFacture(FactureFournisseur $facture): ?string
    {
        $lastLigne = $this->entityManager->getRepository(WorkflowPaiements::class)->getLastWorkflowPaiementsForFacture($facture);

        if ($lastLigne) {
            return $lastLigne->getStatut();
        }

        return null;
    }

    public function isComptableRole(): bool
    {
        $user = $this->security->getUser();

        if (!$user) {
            return false;
        }

        return in_array('ROLE_COMPTABLE', $user->getRoles());
    }

}