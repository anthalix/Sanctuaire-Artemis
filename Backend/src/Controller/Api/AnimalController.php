<?php

namespace App\Controller\Api;

use App\Repository\AnimalsRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;


final class AnimalController extends AbstractController
{


    #[Route('/api/dogs', name: 'app_api_dogs', methods: ['GET'])]
    public function list(AnimalsRepository $am, SerializerInterface $serializer): JsonResponse
    {
        $dogs = $am->getDogs();

        $json = $serializer->serialize($dogs, 'json', ['groups' => 'API']);

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/api/cats', name: 'app_api_cats', methods: ['GET'])]
    public function list2(AnimalsRepository $am, SerializerInterface $serializer): JsonResponse
    {
        $cats = $am->getCats();

        $json = $serializer->serialize($cats, 'json', ['groups' => 'API']);

        return new JsonResponse($json, 200, [], true);
    }
    #[Route('/api/adopted', name: 'app_api_adopts', methods: ['GET'])]
    public function list3(AnimalsRepository $am, SerializerInterface $serializer): JsonResponse
    {
        $adopted = $am->getAdoptes();
        $json = $serializer->serialize($adopted, 'json', ['groups' => 'API']);

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/api/animal/{id}', name: 'app_animal_id', methods: ['GET'])]
    public function single(int $id, AnimalsRepository $am, SerializerInterface $serializer): JsonResponse
    {
        $animal = $am->getSingle($id);

        if (!$animal) {
            return new JsonResponse(['error' => 'Animal not found'], 404);
        }

        $json = $serializer->serialize($animal, 'json', ['groups' => 'API']);
        return new JsonResponse($json, 200, [], true);
    }


}