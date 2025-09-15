<?php

namespace App\Repository;

use App\Entity\Species;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Species>
 */
class SpeciesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Species::class);
    }

    /** @return SpecieDTO[] */

    public function findAllWithCount(): array

    {
        return $this->createQueryBuilder('s')
            ->select('NEW App\\DTO\\SpecieDTO(s.id, s.name, COUNT(a.id))')
            ->leftJoin('s.animals', 'a')
            ->groupBy('s.id')
            ->getQuery()
            ->getResult();
    }


}
