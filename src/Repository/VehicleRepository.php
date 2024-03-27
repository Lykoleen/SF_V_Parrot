<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 *
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Vehicle[]    findBy3()
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findByFilters($filtersBrands = null, $filtersModels = null, $filtersEnergies = null)
    {
        $query = $this->createQueryBuilder('a');
        
        if($filtersBrands) {
            $query->where('a.brands IN(:cats)')
                ->setParameter(':cats', array_values($filtersBrands));
        } 
        if($filtersModels) {
            $query->where('a.models IN(:cats)')
                ->setParameter(':cats', array_values($filtersModels));
        } 
        if($filtersEnergies) {
            $query->where('a.energies IN(:cats)')
                ->setParameter(':cats', array_values($filtersEnergies));
        }
    
        return $query->getQuery()
                    ->getResult();
    }

//    /**
//     * @return Vehicle[] Returns an array of Vehicle objects
//     */
   public function findBy3(): array
   {
       return $this->createQueryBuilder('v')
           ->orderBy('v.id', 'DESC')
           ->setMaxResults(3)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Vehicle
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
