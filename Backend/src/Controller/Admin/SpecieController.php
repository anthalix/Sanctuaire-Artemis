<?php

namespace App\Controller\Admin;

use App\Entity\Species;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\SpeciesRepository;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/species', name: 'species.')]
class SpecieController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SpeciesRepository $species_repository, ): Response
    {

        $species = $species_repository->findAllWithCount();


        return $this->render('admin/specie/index.html.twig', [
            'species' => $species,

            

        ]);
     
    }
}
