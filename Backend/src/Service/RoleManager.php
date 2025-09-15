<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\FrontUser;

use Doctrine\ORM\EntityManagerInterface;

class RoleManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function assignRolesOnVerification(User|FrontUser $user): void
    {
        $roles = $user->getRoles();

        if (method_exists($user, 'isVerified') && $user->isVerified()) {
            $roles[] = $user instanceof FrontUser ? 'ROLE_FRONT' : 'ROLE_USER';

            // Ajout ROLE_ADMIN pour antho@io.fr
            if ($user->getEmail() === 'antho@io.fr') {
                $roles[] = 'ROLE_ADMIN';
            }

            $user->setRoles(array_unique($roles));
            $this->entityManager->flush();
        }
    }
}
