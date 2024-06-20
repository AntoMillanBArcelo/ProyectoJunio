<?php
// src/Controller/Api/ActividadApiController.php

namespace App\Controller\Api;

use App\Entity\DetalleActividad;
use App\Entity\Actividad;
use App\Entity\Evento;
use App\Entity\Espacio;
use App\Entity\Recurso;
use App\Entity\Grupo;
use App\Entity\Ponente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/API')]
class ActividadApiController extends AbstractController
{ 
    #[Route('/recursos', name: 'api_recursos', methods: ['GET'])]
    public function getRecursos(EntityManagerInterface $em): JsonResponse
    {
        $recursos = $em->getRepository(Recurso::class)->findAll();
        $data = [];

        foreach ($recursos as $recurso) {
            $data[] = [
                'id' => $recurso->getId(),
                'descripcion' => $recurso->getDescripcion(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/salas', name: 'api_get_salas', methods: ['GET'])]
    public function getSalas(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $recursoIds = $request->query->get('recursos', '');

        if (is_string($recursoIds)) {
            $recursoIds = explode(',', $recursoIds);
        }

        if (empty($recursoIds) || !is_array($recursoIds)) {
            return new JsonResponse([], JsonResponse::HTTP_BAD_REQUEST);
        }

        $recursos = $em->getRepository(Recurso::class)->findBy(['id' => $recursoIds]);

        $salas = $em->getRepository(Espacio::class)->createQueryBuilder('e')
            ->join('e.recursos', 'r')
            ->where('r.id IN (:recursos)')
            ->groupBy('e.id')
            ->having('COUNT(DISTINCT r.id) = :recurso_count')
            ->setParameter('recursos', $recursoIds)
            ->setParameter('recurso_count', count($recursoIds))
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($salas as $sala) {
            $result[] = [
                'id' => $sala->getId(),
                'nombre' => $sala->getNombre(),
            ];
        }

        return new JsonResponse($result);
    }

    #[Route('/detalle-actividades', name: 'api_detalle_actividades', methods: ['GET'])]
    public function getDetalleActividades(DetalleActividadRepository $detalleActividadRepository): JsonResponse
    {
        $detalleActividades = $detalleActividadRepository->findAll();
        $data = [];
        foreach ($detalleActividades as $detalle) {
            $data[] = [
                'id' => $detalle->getId(),
                'titulo' => $detalle->getTitulo(),
                'descripcion' => $detalle->getDescripcion(),
                'fechaHoraIni' => $detalle->getFechaHoraIni()->format('Y-m-d H:i:s'),
                'fechaHoraFin' => $detalle->getFechaHoraFin()->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }

  
    
    #[Route('/actividades', name: 'actividad_create', methods: ['POST'])]
public function create(Request $request, EntityManagerInterface $em): Response
{
    $data = json_decode($request->getContent(), true);

    $em->getConnection()->beginTransaction();
    try {
        if (!isset($data['descripcion']) || !isset($data['evento']) || !isset($data['fechaInicio']) || !isset($data['fechaFin'])) {
            return $this->json(['error' => 'Datos incompletos para actividad de tipo 2'], Response::HTTP_BAD_REQUEST);
        }

        try 
        {
            $fechaInicio = new \DateTime($data['fechaInicio']);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Fecha de inicio no válida.'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $fechaFin = new \DateTime($data['fechaFin']);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Fecha de fin no válida.'], Response::HTTP_BAD_REQUEST);
        }

        if ($fechaInicio >= $fechaFin) {
            return $this->json(['error' => 'La fecha de inicio debe ser anterior a la fecha de fin.'], Response::HTTP_BAD_REQUEST);
        }

        $actividad = new Actividad();
        $actividad->setDescripcion($data['descripcion']);
        $actividad->setFechaHoraIni($fechaInicio);
        $actividad->setFechaHoraFin($fechaFin);
        $actividad->setTipo('compuesta');

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
    } catch (\Exception $e) {
        $em->getConnection()->rollBack();
        return $this->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    #[Route('/subactividades/simple', name: 'api_actividades_simple', methods: ['POST'])]
    public function createSimple(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    if (
        empty($data['descripcion']) ||
        empty($data['titulo']) ||
        empty($data['fechaInicio']) ||
        empty($data['fechaFin']) 
    ) {
        return $this->json(['error' => 'Faltan datos o datos vacíos
    '], Response::HTTP_BAD_REQUEST);
    }
        
            $em->getConnection()->beginTransaction();
        
            try {
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
        
                foreach ($data['espacios'] as $espacioId) {
                    $espacio = $em->getRepository(Espacio::class)->find($espacioId);
                    if (!$espacio) {
                        $em->getConnection()->rollBack();
                        return $this->json(['error' => 'Espacio no encontrado'], Response::HTTP_NOT_FOUND);
                    }
                $detalleActividad->setDetalleActividadEspacios($espacio);
                }
        
                if (isset($data['id_padre'])) {
                    $detalleActividad->setIdPadre($data['id_padre']);
                }
        
                $em->persist($detalleActividad);
                $em->flush();
        
              

                $em->getConnection()->commit();
        
                return $this->json([
                    'id' => $detalleActividad->getId(),
                    'descripcion' => $detalleActividad->getDescripcion(),
                    'fechaInicio' => $detalleActividad->getFechaHoraIni()->format('d-m-Y H:i:s'),
                    'fechaFin' => $detalleActividad->getFechaHoraFin()->format('d-m-Y H:i:s'),
                    'evento' => [
                        'id' => $evento->getId(),
                        'nombre' => $evento->getTitulo()
                    ],
                    'espacios' => $detalleActividad->getEspacios()->map(function($espacio) {
                        return [
                            'id' => $espacio->getId(),
                            'nombre' => $espacio->getNombre()
                        ];
                    })->toArray()
                ], Response::HTTP_CREATED);
            } 
            catch (\Exception $e) 
            {
                $em->getConnection()->rollBack();
                return $this->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
    }
    
    #[Route('/subactividades/{id}', name: 'api_delete_subactivity', methods: ['DELETE'])]
    public function deleteSubactivity(int $id, EntityManagerInterface $em): JsonResponse
    {
        $subactividad = $em->getRepository(DetalleActividad::class)->find($id);

        if (!$subactividad) {
            return $this->json(['error' => 'Subactividad no encontrada'], JsonResponse::HTTP_NOT_FOUND);
        }

        $em->getConnection()->beginTransaction();
        try {
            $em->remove($subactividad);
            $em->flush();
            $em->getConnection()->commit();
            
            return $this->json(['status' => 'Subactividad borrada exitosamente']);
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            error_log('Error al borrar la subactividad: ' . $e->getMessage());
            return $this->json(['error' => 'Error al borrar la subactividad: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/actividades/{id}', name: 'actividad_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $actividad = $em->getRepository(Actividad::class)->find($id);

        if (!$actividad) {
            return $this->json(['error' => 'actividad no encontrada'], JsonResponse::HTTP_NOT_FOUND);
        }

        $em->getConnection()->beginTransaction();
        try {
            $em->remove($actividad);
            $em->flush();
            $em->getConnection()->commit();
            
            return $this->json(['status' => 'actividad borrada exitosamente']);
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            error_log('Error al borrar la actividad: ' . $e->getMessage());
            return $this->json(['error' => 'Error al borrar la actividad: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    #[Route('/subactividades/{id}', name: 'api_get_actividad', methods: ['GET'])]
    public function update(Request $request, DetalleActividad $detalleActividad): Response
    {
        $data = json_decode($request->getContent(), true);

        $detalleActividad->setTitulo($data['Titulo'] ?? $detalleActividad->getTitulo());
        $detalleActividad->setFechaHoraIni(new \DateTime($data['FechaHoraIni']) ?? $detalleActividad->getFechaHoraIni());
        $detalleActividad->setFechaHoraFin(new \DateTime($data['FechaHoraFin']) ?? $detalleActividad->getFechaHoraFin());
        $detalleActividad->setDescripcion($data['descripcion'] ?? $detalleActividad->getDescripcion());

        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $this->json(['error' => 'Error al actualizar el detalle de la actividad: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(['message' => 'Detalle de la actividad actualizado correctamente'], Response::HTTP_OK);
    }

    #[Route('/subactividades/{id}', name: 'api_update_subactividad', methods: ['PUT'])]
    public function updateSubactividad(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $subactividad = $em->getRepository(DetalleActividad::class)->find($id);

        if (!$subactividad) {
            return $this->json(['error' => 'Subactividad no encontrada'], Response::HTTP_NOT_FOUND);
        }

        if (isset($data['titulo'])) {
            $subactividad->setTitulo($data['titulo']);
        }
        if (isset($data['fechaInicio'])) {
            $subactividad->setFechaHoraIni(new \DateTime($data['fechaInicio']));
        }
        if (isset($data['fechaFin'])) {
            $subactividad->setFechaHoraFin(new \DateTime($data['fechaFin']));
        }
        if (isset($data['descripcion'])) {
            $subactividad->setDescripcion($data['descripcion']);
        }

        try {
            $em->flush();
            return $this->json(['message' => 'Subactividad actualizada correctamente'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Error al actualizar la subactividad: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/actividades/{id}', name: 'api_get_actividad', methods: ['GET', 'PUT'])]
    public function handleActividad(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $actividad = $em->getRepository(Actividad::class)->find($id);

        if (!$actividad) {
            return $this->json(['error' => 'Actividad no encontrada'], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($request->getMethod() === 'GET') {
            return $this->json([
                'id' => $actividad->getId(),
                'descripcion' => $actividad->getDescripcion(),
                'fechaHoraIni' => $actividad->getFechaHoraIni()->format('Y-m-d H:i:s'),
                'fechaHoraFin' => $actividad->getFechaHoraFin()->format('Y-m-d H:i:s'),
            ]);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['descripcion'])) {
            $actividad->setDescripcion($data['descripcion']);
        }
        if (isset($data['fechaInicio'])) {
            $actividad->setFechaHoraIni(new \DateTime($data['fechaInicio']));
        }
        if (isset($data['fechaFin'])) {
            $actividad->setFechaHoraFin(new \DateTime($data['fechaFin']));
        }

        try {
            $em->flush();
            return $this->json(['status' => 'Actividad actualizada exitosamente']);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Error al actualizar la actividad: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/asociar_evento_detalle_actividad/{id}', name: 'api_asociar_evento_detalle_actividad', methods: ['POST'])]
    public function asociarEventoDetalleActividad(Request $request, DetalleActividad $detalleActividad, Evento $evento): Response
    {
            $detalleActividad->setEvento($evento);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->json([
                'message' => 'Evento asociado correctamente al detalle de actividad.',
                'detalleActividad' => $detalleActividad->getId(),
                'evento' => $evento->getId(),
            ]);
    }
}
