<?php
namespace App\Security\Voter;

use App\Entity\FrontUser;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class IsVerifiedVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === 'IS_VERIFIED';
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // Vérifie si c'est un User ou un FrontUser
        if (!$user instanceof User && !$user instanceof FrontUser) {
            return false;
        }

        return $user->isVerified();
    }
}
