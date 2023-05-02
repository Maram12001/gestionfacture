<?php

namespace App\Repository;

use App\Entity\ActionType;
use App\Entity\FactureFournisseur;
use App\Entity\Fournisseur;
use App\Entity\UserLeadAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FactureFournisseur>
 *
 * @method FactureFournisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method FactureFournisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method FactureFournisseur[]    findAll()
 * @method FactureFournisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureFournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FactureFournisseur::class);
    }

    public function save(FactureFournisseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FactureFournisseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Retourner les top Fournisseurs
     * @return array
     */
    public function findTopFournisseur(): array
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->select('s.raisonSociale, COUNT(f.id) as factures')
            ->innerJoin(Fournisseur::class, 's', 'WITH', 's.id = f.fournisseur')
            ->groupBy('s.raisonSociale')
            ->orderBy('factures', 'DESC')
            ->setMaxResults(10);

        $results = $queryBuilder->getQuery()->getResult();
        return $results;

    }
}
