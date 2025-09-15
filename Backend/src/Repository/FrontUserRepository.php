<?php


namespace App\Repository;

use App\Entity\FrontUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
* @extends ServiceEntityRepository<FrontUser>
    */
    class FrontUserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
    {
    public function __construct(ManagerRegistry $registry)
    {
    parent::__construct($registry, FrontUser::class);
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
    if (!$user instanceof FrontUser) {
    throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
    }

    $user->setPassword($newHashedPassword);
    $this->getEntityManager()->persist($user);
    $this->getEntityManager()->flush();
    }

    public function findByEmailOrUsername(string $usernameOrEmail): ?frontuser
    {
    return $this->createQueryBuilder('u')
    ->andWhere('u.email = :identifier OR u.username = :identifier')
    ->setParameter('identifier', $usernameOrEmail)
    ->setMaxResults(1)
    ->getQuery()
    ->getOneOrNullResult();
    }
    }
