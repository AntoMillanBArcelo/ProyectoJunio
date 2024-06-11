<?php
// src/Controller/Api/ActividadApiController.php

namespace App\Controller\Api;

use App\Entity\DetalleActividad;
use App\Entity\Evento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/API')]
class ActividadApiController extends AbstractController
{
    #[Route('/actividades', name: 'actividad_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['tipo'])) {
            return $this->json(['error' => 'Tipo no especificado'], Response::HTTP_BAD_REQUEST);
        }

        $em->getConnection()->beginTransaction();
        try {
            if ($data['tipo'] == 2) {
                if (!isset($data['descripcion']) || !isset($data['evento']) || !isset($data['fechaInicio']) || !isset($data['fechaFin'])) {
                    return $this->json(['error' => 'Datos incompletos para actividad de tipo 2'], Response::HTTP_BAD_REQUEST);
                }

                $fechaInicio = new \DateTime($data['fechaInicio']);
                $fechaFin = new \DateTime($data['fechaFin']);

                $actividad = new Actividad();
                $actividad->setDescripcion($data['descripcion']);
                $actividad->setFechaHoraIni($fechaInicio);
                $actividad->setFechaHoraFin($fechaFin);
                $actividad->setTipo($data['tipo']);

                $evento = $em->getRepository(Evento::class)->find($data['evento']);
                if (!$evento) {
                    return $this->json(['error' => 'Evento no encontrado'], Response::HTTP_NOT_FOUND);
                }
                $actividad->setEvento($evento);

                $em->persist($actividad);
                $em->flush();

                $em->getConnection()->commit();

                return $this->json([
                    'id' => $actividad->getId(),
                    'descripcion' => $actividad->getDescripcion(),
                    'fechaHoraInicio' => $actividad->getFechaHoraIni()->format('d-m-Y H:i:s'),
                    'fechaHoraFin' => $actividad->getFechaHoraFin()->format('d-m-Y H:i:s'),
                    'tipo' => $actividad->getTipo(),
                    'evento' => [
                        'id' => $evento->getId(),
                        'nombre' => $evento->getTitulo()
                    ]
                ], Response::HTTP_CREATED);
            } else {
                return $this->json(['error' => 'Tipo no soportado'], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            return $this->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    #[Route('/actividades/simple', name: 'api_actividades_simple', methods: ['POST'])]
    public function createSimple(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validación de que estos campos sean obligatorios
        if (!isset($data['descripcion']) || !isset($data['fechaInicio']) || !isset($data['fechaFin']) || !isset($data['evento'])) {
            return $this->json(['error' => 'Datos incompletos'], Response::HTTP_BAD_REQUEST);
        }

        $detalleActividad = new DetalleActividad();
        $detalleActividad->setDescripcion($data['descripcion']);
        $detalleActividad->setFechaHoraIni(new \DateTime($data['fechaInicio']));
        $detalleActividad->setFechaHoraFin(new \DateTime($data['fechaFin']));
        $detalleActividad->setTitulo($data['titulo']);

        $evento = $em->getRepository(Evento::class)->find($data['evento']);
        if (!$evento) {
            return $this->json(['error' => 'Evento no encontrado'], Response::HTTP_NOT_FOUND);
        }
        $detalleActividad->setEvento($evento);

        $em->getConnection()->beginTransaction();
        try {
            $em->persist($detalleActividad);
            $em->flush();

            if (isset($data['ponentes']) && is_array($data['ponentes'])) {
                $this->updatePonentes($em, $detalleActividad, $data['ponentes']);
            }

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            return $this->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'id' => $detalleActividad->getId(),
            'descripcion' => $detalleActividad->getDescripcion(),
            'fechaInicio' => $detalleActividad->getFechaHoraIni()->format('Y-m-d H:i:s'),
            'fechaFin' => $detalleActividad->getFechaHoraFin()->format('Y-m-d H:i:s'),
            'evento' => [
                'id' => $evento->getId(),
                'nombre' => $evento->getTitulo()
            ],
            'tipo' => 'simple'
        ], Response::HTTP_CREATED);
    }

    private function updatePonentes(EntityManagerInterface $em, DetalleActividad $detalleActividad, array $ponentesData)
    {
        if (!is_array($ponentesData)) {
            throw new \InvalidArgumentException('Los datos de los ponentes deben ser proporcionados como un array.');
        }

        foreach ($ponentesData as $ponenteData) {
            if (!isset($ponenteData['nombre']) || !isset($ponenteData['cargo']) || !isset($ponenteData['recurso'])) {
                throw new \InvalidArgumentException('Los datos de cada ponente deben incluir "nombre", "cargo" y "recurso".');
            }

            $ponente = new Ponente();
            $ponente->setNombre($ponenteData['nombre']);
            $ponente->setCargo($ponenteData['cargo']);
            $ponente->setUrl($ponenteData['recurso']);
            $ponente->setPonenteDetalleActividad($detalleActividad);

            $em->persist($ponente);
        }

        $em->flush();
    }
}
