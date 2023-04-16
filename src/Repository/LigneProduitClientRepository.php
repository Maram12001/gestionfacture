<?php

namespace App\Repository;

use App\Entity\LigneProduitClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneProduitClient>
 *
 * @method LigneProduitClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneProduitClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneProduitClient[]    findAll()
 * @method LigneProduitClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneProduitClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneProduitClient::class);
    }

    public function save(LigneProduitClient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LigneProduitClient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LigneProduitClient[] Returns an array of LigneProduitClient objects
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

//    public function findOneBySomeField($value): ?LigneProduitClient
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
