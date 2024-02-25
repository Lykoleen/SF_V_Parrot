<?php

namespace App\Repository;

use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Picture>
 *
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

//    /**
//     * @return Picture[] Returns an array of Picture objects
//     */
   public function findOneByProductId($value): array
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.products = :val')
           ->setParameter('val', $value)
           ->setMaxResults(1)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findOneByServiceId($value): ?Picture
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.services = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
