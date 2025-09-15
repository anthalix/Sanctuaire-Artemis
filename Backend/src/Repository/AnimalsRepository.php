<?php

namespace App\Repository;

use App\Entity\Animals;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Animals>
 */
class AnimalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Animals::class);
    }

    public function paginate(int $page): PaginationInterface
    {

        return $this->paginator->paginate(
            $this->createQueryBuilder('a')->leftJoin('a.specie', 's')->select('a', 's'),
         
           
             
            $page,
            6
   

        );

 
    }


public function getDogs(): array
{
    return $this->createQueryBuilder('a')
        ->join('a.specie', 's')
        ->leftJoin('a.breeds', 'b') // Jointure sur les breeds associées
        ->addSelect('b')
        ->andWhere('s.id = :dogSpeciesId')
        ->andWhere('a.status IN (:statuses)')
        ->setParameter('dogSpeciesId', 1) // 1 = id de la race chien
        ->setParameter('statuses', ['disponible', 'urgent'])
        ->getQuery()
        ->getResult();
}

    public function getCats()
    { return $this->createQueryBuilder('a')
        ->join('a.specie', 's')
        ->leftJoin('a.breeds', 'b') // Jointure sur les breeds associées
        ->addSelect('b')
        ->andWhere('s.id = :catSpeciesId')
        ->andWhere('a.status IN (:statuses)')
        ->setParameter('catSpeciesId', 2) // 1 = id de la race chien
        ->setParameter('statuses', ['disponible', 'urgent'])
        ->getQuery()
        ->getResult();
     
    }
    public function getAdoptes()
    {
        return $this->createQueryBuilder('a')
            ->where('a.status IN (:statuses)')
            ->setParameter('statuses', ['adopté'])
            ->getQuery()
            ->getResult();
    }
    public function getSingle(int $id)
{
    return $this->createQueryBuilder('a')
        ->leftJoin('a.specie', 's')
        ->addSelect('s')
        ->leftJoin('a.breeds', 'b')
        ->addSelect('b')
        ->andWhere('a.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getOneOrNullResult(); // retourne un seul résultat ou null si non trouvé
}



   
}
