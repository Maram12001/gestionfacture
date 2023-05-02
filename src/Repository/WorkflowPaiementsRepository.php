<?php

namespace App\Repository;

use App\Entity\FactureFournisseur;
use App\Entity\WorkflowPaiements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkflowPaiements>
 *
 * @method WorkflowPaiements|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkflowPaiements|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkflowPaiements[]    findAll()
 * @method WorkflowPaiements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkflowPaiementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkflowPaiements::class);
    }

    public function save(WorkflowPaiements $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WorkflowPaiements $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getLastWorkflowPaiementsForFacture(FactureFournisseur $factureFournisseur){

        return $this->createQueryBuilder('w')
            ->where('w.factureFournisseur = :facture')
            ->setParameter('facture', $factureFournisseur)
            ->orderBy('w.dateEmission', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

    }
//    /**
//     * @return WorkflowPaiements[] Returns an array of WorkflowPaiements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WorkflowPaiements
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
