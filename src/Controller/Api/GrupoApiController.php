<?php

namespace App\Controller\Api;

use App\Entity\Grupo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/grupos")
 */
class GrupoApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/", name="api_grupo_list", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Grupo::class);
        $grupos = $repository->findAll();
        $data = [];
    
        foreach ($grupos as $grupo) {
            $data[] = $this->serializeGrupo($grupo);
        }
    
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="api_grupo_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $grupo = $this->entityManager->getRepository(Grupo::class)->find($id);

        if (!$grupo) {
            return new JsonResponse(['message' => 'Grupo no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializeGrupo($grupo);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/", name="api_grupo_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
     
        if (!isset($data['Nombre'])) {
            return new JsonResponse(['message' => 'Nombre es requerido'], Response::HTTP_BAD_REQUEST);
        }

        $grupo = new Grupo();
        $grupo->setNombre($data['Nombre']);

        $this->entityManager->persist($grupo);
        $this->entityManager->flush();

        $responseData = $this->serializeGrupo($grupo);
        return new JsonResponse($responseData, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="api_grupo_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $grupo = $this->entityManager->getRepository(Grupo::class)->find($id);

        if (!$grupo) {
            return new JsonResponse(['message' => 'Grupo no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($grupo);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function serializeGrupo(Grupo $grupo): array
    {
        return [
            'id' => $grupo->getId(),
            'Nombre' => $grupo->getNombre(),
        ];
    }
}
