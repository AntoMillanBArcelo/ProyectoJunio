<?php

namespace App\Controller\Api;

use App\Entity\Recurso;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/recursos")
 */
class RecursoApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/", name="api_recurso_list", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Recurso::class);
        $recursos = $repository->findAll();
        $data = [];
    
        foreach ($recursos as $recurso) {
            $data[] = $this->serializeRecurso($recurso);
        }
    
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="api_recurso_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $recurso = $this->entityManager->getRepository(Recurso::class)->find($id);

        if (!$recurso) {
            return new JsonResponse(['message' => 'Recurso no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializeRecurso($recurso);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/", name="api_recurso_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
     
        if (!isset($data['Descripcion'])) {
            return new JsonResponse(['message' => 'Descripcion es requerida'], Response::HTTP_BAD_REQUEST);
        }

        $recurso = new Recurso();
        $recurso->setDescripcion($data['Descripcion']);

        $this->entityManager->persist($recurso);
        $this->entityManager->flush();

        $responseData = $this->serializeRecurso($recurso);
        return new JsonResponse($responseData, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="api_recurso_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $recurso = $this->entityManager->getRepository(Recurso::class)->find($id);

        if (!$recurso) {
            return new JsonResponse(['message' => 'Recurso no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($recurso);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function serializeRecurso(Recurso $recurso): array
    {
        return [
            'id' => $recurso->getId(),
            'Descripcion' => $recurso->getDescripcion(),
        ];
    }
}
