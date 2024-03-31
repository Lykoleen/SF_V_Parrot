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

    public function findByFilters($filtersBrands = null, $filtersModels = null, $filtersEnergies = null, $filtersMinPrice = null, $filtersMaxPrice = null, $filtersMinYears = null, $filtersMaxYears = null, $filtersMinMileage = null, $filtersMaxMileage = null)
    {
        $query = $this->createQueryBuilder('a');
        
            $conditions = [];
        
            if($filtersBrands) {
                $conditions[] = 'a.brands IN (:brands)';
            }
            if($filtersModels) {
                $conditions[] = 'a.models IN (:models)';
            }
            if($filtersEnergies) {
                $conditions[] = 'a.energies IN (:energies)';
            }
            if ($filtersMinPrice !== null && $filtersMaxPrice !== null) {
                $conditions[] = 'a.price BETWEEN :minPrice AND :maxPrice';
            }
            if ($filtersMinYears !== null && $filtersMaxYears !== null) {
                $conditions[] = 'a.years BETWEEN :minYears AND :maxYears';
            }
            if ($filtersMinMileage !== null && $filtersMaxMileage !== null) {
                $conditions[] = 'a.mileage BETWEEN :minMileage AND :maxMileage';
            }
        
            $query->andWhere(implode(' AND ', $conditions));
        
            if($filtersBrands) {
                $query->setParameter(':brands', array_values($filtersBrands));
            }
            if($filtersModels) {
                $query->setParameter(':models', array_values($filtersModels));
            }
            if($filtersEnergies) {
                $query->setParameter(':energies', array_values($filtersEnergies));
            }
            if ($filtersMinPrice !== null && $filtersMaxPrice !== null) {
                $query->setParameter(':minPrice', $filtersMinPrice);
                $query->setParameter(':maxPrice', $filtersMaxPrice);
            }
            if ($filtersMinYears !== null && $filtersMaxYears !== null) {
                $query->setParameter(':minYears', $filtersMinYears);
                $query->setParameter(':maxYears', $filtersMaxYears);
            }
            if ($filtersMinMileage !== null && $filtersMaxMileage !== null) {
                $query->setParameter(':minMileage', $filtersMinMileage);
                $query->setParameter(':maxMileage', $filtersMaxMileage);
            }
    
        $query->orderBy('a.brands', 'ASC');
    
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
