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
    // Récupère les rôles existants, ou tableau vide
    $roles = $user->getRoles() ?? [];

    // Vérifie que l'utilisateur est bien vérifié
    if (method_exists($user, 'isVerified') && $user->isVerified()) {

        // Assigne le rôle correspondant selon le type d'utilisateur
        if ($user instanceof FrontUser && !in_array('ROLE_FRONT', $roles)) {
            $roles[] = 'ROLE_FRONT';
        } elseif ($user instanceof User && !in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        // Cas spécial : ROLE_ADMIN pour antho@io.fr
        if ($user->getEmail() === 'antho@io.fr' && !in_array('ROLE_ADMIN', $roles)) {
            $roles[] = 'ROLE_ADMIN';
        }

        // Supprime les doublons et met à jour
        $user->setRoles(array_unique($roles));
    }
}

}
