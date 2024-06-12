<?php
// src/Controller/Api/ActividadApiController.php

namespace App\Controller\Api;

use App\Entity\DetalleActividad;
use App\Entity\Actividad;
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
    
        if (isset($data['id_padre'])) {
            $detalleActividad->setIdPadre($data['id_padre']);
            error_log('ID Padre establecido: ' . $data['id_padre']);
        } else {
            error_log('ID Padre no está presente en la solicitud.');
        }
    
        $em->getConnection()->beginTransaction();
        try {
            $em->persist($detalleActividad);
            $em->flush();
    
            $ponentes = [];
            if (isset($data['ponentes']) && is_array($data['ponentes'])) {
                $this->updatePonentesWithActividadId($em, $detalleActividad, $data['ponentes']);
                $ponentes = $data['ponentes'];
            }
    
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
                'tipo' => 'simple',
                'ponentes' => $ponentes
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $em->getConnection()->rollBack();
            return $this->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    



    private function updatePonentesWithActividadId(EntityManagerInterface $em, DetalleActividad $detalleActividad, array $ponentesData): void
    {
        foreach ($ponentesData as $ponenteData) {
            if (!isset($ponenteData['id'])) {
                throw new \InvalidArgumentException('Cada ponente debe tener un ID.');
            }

            $ponenteId = $ponenteData['id'];
            $ponente = $em->getRepository(Ponente::class)->find($ponenteId);

            if ($ponente) {
                $ponente->setPonenteDetalleActividad($detalleActividad);
            }
        }

        $em->flush();
    }

    #[Route('/actividades/update-ponentes', name: 'update_ponentes', methods: ['POST'])]
    public function updatePonentes(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['actividad_id']) || !isset($data['ponentes'])) 
        {
            return $this->json(['error' => 'Datos incompletos'], Response::HTTP_BAD_REQUEST);
        }

        $detalleActividad = $em->getRepository(DetalleActividad::class)->find($data['actividad_id']);
        if (!$detalleActividad) 
        {
            return $this->json(['error' => 'Actividad no encontrada'], Response::HTTP_NOT_FOUND);
        }

        try 
        {
            $this->updatePonentesWithActividadId($em, $detalleActividad, $data['ponentes']);
        } 
        catch (\Exception $e) 
        {
            return $this->json(['error' => 'Error al actualizar los ponentes: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['status' => 'Ponentes actualizados exitosamente']);
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

    #[Route('/subactividades/{id}', name: 'api_update_subactivity', methods: ['PUT'])]
public function updateSubactivity(int $id, Request $request, EntityManagerInterface $em): JsonResponse
{
    $subactividad = $em->getRepository(DetalleActividad::class)->find($id);

    if (!$subactividad) {
        return $this->json(['error' => 'Subactividad no encontrada'], JsonResponse::HTTP_NOT_FOUND);
    }

    $data = json_decode($request->getContent(), true);

    // Aquí deberías validar los datos recibidos en $data para garantizar que sean correctos

    $em->getConnection()->beginTransaction();
    try {
        // Actualizar los campos de la subactividad con los datos recibidos
        if (isset($data['descripcion'])) {
            $subactividad->setDescripcion($data['descripcion']);
        }
        if (isset($data['fechaInicio'])) {
            $subactividad->setFechaHoraIni(new \DateTime($data['fechaInicio']));
        }
        if (isset($data['fechaFin'])) {
            $subactividad->setFechaHoraFin(new \DateTime($data['fechaFin']));
        }

        // Persistir los cambios en la base de datos
        $em->flush();
        $em->getConnection()->commit();
        
        return $this->json(['status' => 'Subactividad actualizada exitosamente']);
    } catch (\Exception $e) {
        // Si ocurre un error, hacer rollback de la transacción y devolver un error
        $em->getConnection()->rollBack();
        error_log('Error al actualizar la subactividad: ' . $e->getMessage());
        return $this->json(['error' => 'Error al actualizar la subactividad: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}

}
