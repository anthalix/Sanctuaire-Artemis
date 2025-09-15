<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le nom est requis')]
        #[Assert\Length(min: 2, max: 50, minMessage: 'Le nom doit contenir au moins {{ limit }} caractères', maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères')]
        #[Assert\Regex(pattern: '/^[a-zA-Z\s]+$/', message: 'Le nom ne peut contenir que des lettres et des espaces')]
        public string $name = '',
        #[Assert\NotBlank(message: 'L\'email est requis')]
        #[Assert\Email(message: 'L\'email "{{ value }}" n\'est pas valide')]
        public string $email = '',
        #[Assert\NotBlank(message: 'Le message est requis')]
        #[Assert\Length(min: 10, max: 1000, minMessage: 'Le message doit contenir au moins {{ limit }} caractères', maxMessage: 'Le message ne peut pas dépasser {{ limit }} caractères')]
        public string $message = '',
    ) {
    }
}