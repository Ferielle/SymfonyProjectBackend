<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository, SerializerInterface $serializer): JsonResponse
    {
        $evenements = $evenementRepository->findAll();
        $data = $serializer->normalize($evenements, null, ['groups' => 'evenement']);

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getContent();
        
        $evenement = $serializer->deserialize($data, Evenement::class, 'json');
        $errors = $validator->validate($evenement);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return new JsonResponse(['error' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($evenement);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Evenement added successfully'], JsonResponse::HTTP_CREATED);
    }
    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->normalize($evenement, null, ['groups' => 'evenement']);
    
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
    
    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['PUT'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getContent();
        $serializer->deserialize($data, Evenement::class, 'json', ['object_to_populate' => $evenement]);
    
        $errors = $validator->validate($evenement);
    
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
    
            return new JsonResponse(['error' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }
    
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Evenement updated successfully'], JsonResponse::HTTP_OK);
    }
    
    #[Route('/{id}', name: 'app_evenement_delete', methods: ['DELETE'])]
    public function delete(Evenement $evenement, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($evenement);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Evenement deleted successfully'], JsonResponse::HTTP_OK);
    }
}
