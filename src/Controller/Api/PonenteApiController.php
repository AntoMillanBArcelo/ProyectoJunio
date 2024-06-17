<?php

namespace App\Controller\Api;

use App\Entity\Ponente;
use App\Entity\Evento;
use App\Entity\DetalleActividad;
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

        if (!isset($data['nombre']) || !isset($data['cargo']) || !isset($data['url'])) {
            return $this->json(['error' => 'Datos incompletos para guardar el ponente'], Response::HTTP_BAD_REQUEST);
        }


        $detalleActividad = $em->getRepository(DetalleActividad::class)->findOneBy([], ['id' => 'DESC']);
        if (!$detalleActividad) {
            return $this->json(['error' => 'No se encontró DetalleActividad'], Response::HTTP_NOT_FOUND);
        }

        $ponente = new Ponente();
        $ponente->setNombre($data['nombre']);
        $ponente->setCargo($data['cargo']);
        $ponente->setUrl($data['url']);
        $ponente->setPonenteDetalleActividad($detalleActividad);

        if (isset($data['evento_id'])) {
            $evento = $em->getRepository(Evento::class)->find($data['evento_id']);
            if (!$evento) {
                return $this->json(['error' => 'Evento no encontrado'], Response::HTTP_NOT_FOUND);
            }
            $ponente->setEvento($evento);
        }

        try {
            $em->persist($ponente);
            $em->flush();
        } catch (\Exception $e) {
            return $this->json(['error' => 'Error al guardar el ponente: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'Ponente guardado correctamente'], Response::HTTP_CREATED);
    }

    #[Route('/ponentes/ultimo', name: 'actualizar_ultimo_ponente', methods: ['POST'])]
    public function actualizarUltimoPonente(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);
        $actividadId = $data['actividadId'];
        
        $actividad = $em->getRepository(DetalleActividad::class)->find($actividadId);
        if (!$actividad) {
            return new Response(json_encode(['error' => 'Actividad no encontrada']), 404, ['Content-Type' => 'application/json']);
        }

        $ultimoPonente = $em->getRepository(Ponente::class)->findOneBy([], ['id' => 'DESC']);
        if ($ultimoPonente) {
            $ultimoPonente->setPonenteDetalleActividad($actividad);
            $em->persist($ultimoPonente);
            $em->flush();
            return new Response(json_encode(['success' => 'Ponente actualizado exitosamente']), 200, ['Content-Type' => 'application/json']);
        }

        return new Response(json_encode(['error' => 'Ponente no encontrado']), 404, ['Content-Type' => 'application/json']);
    }
}
