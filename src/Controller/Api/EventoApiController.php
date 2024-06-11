<?php

namespace App\Controller\Api;

use App\Entity\Evento;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/eventos")
 */
class EventoApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="api_evento_list", methods={"GET"})
     */
    public function index(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Evento::class);
        $eventos = $repository->findAll();
        $data = [];

        foreach ($eventos as $evento) {
            $data[] = $this->serializeEvento($evento);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="api_evento_show", methods={"GET"})
     */
    public function show(int $id): JsonResponse
    {
        $evento = $this->entityManager->getRepository(Evento::class)->find($id);

        if (!$evento) {
            return new JsonResponse(['message' => 'Evento not found'], Response::HTTP_NOT_FOUND);
        }

        $data = $this->serializeEvento($evento);

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/", name="api_evento_create", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['titulo'], $data['fechaInicio'], $data['fechaFin'])) {
            return new JsonResponse(['message' => 'Datos incompletos para crear el evento'], Response::HTTP_BAD_REQUEST);
        }

        $evento = new Evento();
        $evento->setTitulo($data['titulo']);
        $evento->setFechaInicio(new \DateTime($data['fechaInicio']));
        $evento->setFechaFin(new \DateTime($data['fechaFin']));

        $this->entityManager->persist($evento);
        $this->entityManager->flush();

        $responseData = $this->serializeEvento($evento);
        return new JsonResponse($responseData, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="api_evento_delete", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $evento = $this->entityManager->getRepository(Evento::class)->find($id);

        if (!$evento) {
            return new JsonResponse(['message' => 'Evento not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($evento);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function serializeEvento(Evento $evento): array
    {
        return [
            'id' => $evento->getId(),
            'titulo' => $evento->getTitulo(),
            'fechaInicio' => $evento->getFechaInicio()->format('Y-m-d'),
            'fechaFin' => $evento->getFechaFin()->format('Y-m-d'),
        ];
    }
}
