<?php

namespace App\Repository;

use App\Entity\LigneProduitFournisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneProduitFournisseur>
 *
 * @method LigneProduitFournisseur|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneProduitFournisseur|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneProduitFournisseur[]    findAll()
 * @method LigneProduitFournisseur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneProduitFournisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneProduitFournisseur::class);
    }

    public function save(LigneProduitFournisseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LigneProduitFournisseur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LigneProduitFournisseur[] Returns an array of LigneProduitFournisseur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LigneProduitFournisseur
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
