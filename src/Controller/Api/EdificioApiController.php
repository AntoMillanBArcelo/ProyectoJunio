<?php

namespace App\Controller\Api;

use App\Entity\Edificio;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/edificios")
 */
class EdificioApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="api_edificio_list", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Edificio::class);
        $edificios = $repository->findAll();
        $data = [];

        foreach ($edificios as $edificio) {
            $data[] = $this->serializeEdificio($edificio);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="api_edificio_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $edificio = $this->entityManager->getRepository(Edificio::class)->find($id);

        if (!$edificio) {
            return new JsonResponse(['message' => 'Edificio not found'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializeEdificio($edificio);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/", name="api_edificio_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nombre'])) {
            return new JsonResponse(['message' => 'El nombre del edificio es requerido'], Response::HTTP_BAD_REQUEST);
        }

        $edificio = new Edificio();
        $edificio->setNombre($data['nombre']);

        $this->entityManager->persist($edificio);
        $this->entityManager->flush();

        $responseData = $this->serializeEdificio($edificio);
        return new JsonResponse($responseData, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="api_edificio_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $edificio = $this->entityManager->getRepository(Edificio::class)->find($id);

        if (!$edificio) {
            return new JsonResponse(['message' => 'Edificio not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($edificio);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function serializeEdificio(Edificio $edificio): array
    {
        return [
            'id' => $edificio->getId(),
            'nombre' => $edificio->getNombre(),
        ];
    }
}
