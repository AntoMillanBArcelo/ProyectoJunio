<?php

namespace App\Controller\Api;

use App\Entity\Ponente;
use App\Entity\Evento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/API')]
class PonenteApiController extends AbstractController
{
    #[Route('/ponentes', name: 'guardar_ponente', methods: ['POST'])]
    public function guardarPonente(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nombre']) || !isset($data['cargo']) || !isset($data['url']) || !isset($data['evento_id'])) {
            return $this->json(['error' => 'Datos incompletos para guardar el ponente'], Response::HTTP_BAD_REQUEST);
        }

        $evento = $em->getRepository(Evento::class)->find($data['evento_id']);
        if (!$evento) {
            return $this->json(['error' => 'Evento no encontrado'], Response::HTTP_NOT_FOUND);
        }

        $ponente = new Ponente();
        $ponente->setNombre($data['nombre']);
        $ponente->setCArgo($data['cargo']);
        $ponente->setURL($data['url']);
        $ponente->setEvento($evento);

        try {
            $em->persist($ponente);
            $em->flush();
        } catch (\Exception $e) {
            return $this->json(['error' => 'Error al guardar el ponente: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'Ponente guardado correctamente'], Response::HTTP_CREATED);
    }
}
