<?php

namespace App\Controller\Admin;

use App\Entity\Breeds;
use App\Entity\Animals;
use App\Form\AnimalTypeForm;
use App\Repository\AnimalsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[IsGranted('ROLE_USER')]
#[Route('/admin/animals', name: 'admin.animals.')]


final class AnimalController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(AnimalsRepository $animals_repository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        $animals = $animals_repository->paginate($page);

        return $this->render('admin/animal/index.html.twig', [
            'animals' => $animals,

        ]);
    }
    #[IsGranted('ROLE_ADMIN')]

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $animal = new Animals();
        $form = $this->createForm(AnimalTypeForm::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Handle the form submission and save the animal entity
            $newBreedName = $form->get('newBreed')->getData();

            if ($newBreedName) {
                $newBreed = new Breeds();
                $newBreed->setName($newBreedName);
                $em->persist($newBreed);

                // Ajouter cette nouvelle race à l'animal
                $animal->addBreed($newBreed);
            }

            try {
                $em->persist($animal);

                $em->flush();
                $this->addFlash(
                    'success',
                    'Animal créer avec succès !'
                );
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue : ' . $e->getMessage());
            }
            // Redirect to the index page after creating the animal
            return $this->redirectToRoute('admin.animals.index');
        }

        // Render the create template with the form
        {
            return $this->render('admin/animal/create.html.twig', [
                'form' => $form,
            ]);
        }
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    #[IsGranted('ROLE_ADMIN')]

    public function edit(Animals $animals, Request $request, EntityManagerInterface $em)
    {


        $form = $this->createForm(AnimalTypeForm::class, $animals ,['is_edit' => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {




            $em->flush();
            $this->addFlash(
                'success',
                'Animal modifier avec succès !'
            );

            // Rediriger vers la page des animaux après l'édition
            return $this->redirectToRoute('admin.animals.index');
        }

        return $this->render('admin/animal/edit.html.twig', [
            'animal' => $animals,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete(Animals $animals, EntityManagerInterface $em): Response
    {
        $em->remove($animals);
        $em->flush();

        $this->addFlash(
            'success',
            'Animal supprimer avec succès !'
        );

        // Redirect to the index page after deleting the animal
        return $this->redirectToRoute('admin.animals.index');
    }
}
