<?php

namespace App\Controller\Admin;

use App\Repository\FrontUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/users', name: 'admin.users.' ,methods: ['GET'])]



class UserController extends AbstractController
{
    #[Route('/', name: 'list' ,methods: ['GET'])]

    public function list(FrontUserRepository $frontuserRepository, ): Response
    {
        $users = $frontuserRepository->findAll();


        return $this->render('admin/users/list.html.twig', [

            'users' => $users,
            ]);


    }
}
