<?php

namespace App\Repository;

use App\Entity\Workflowpaiement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workflowpaiement>
 *
 * @method Workflowpaiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workflowpaiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workflowpaiement[]    findAll()
 * @method Workflowpaiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkflowpaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workflowpaiement::class);
    }

    public function save(Workflowpaiement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Workflowpaiement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Workflowpaiement[] Returns an array of Workflowpaiement objects
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

//    public function findOneBySomeField($value): ?Workflowpaiement
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
