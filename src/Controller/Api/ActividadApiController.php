<?php
namespace App\Controller\Api;

use App\Entity\Actividad;
use App\Entity\DetalleActividad;
use App\Entity\Espacio;
use App\Entity\Evento;
use App\Entity\Ponente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/API')]
class ActividadApiController extends AbstractController
{
    #[Route('/actividades', name: 'actividad_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $actividades = $em->getRepository(Actividad::class)->findAll();
        $data = [];
        foreach ($actividades as $actividad) {
            $data[] = $this->serializeActividad($actividad);
        }
        return $this->json($data);
    }

    #[Route('/actividades/{id}', name: 'actividad_show', methods: ['GET'])]
    public function show(EntityManagerInterface $em, int $id): Response
    {
        $actividad = $em->getRepository(Actividad::class)->find($id);
        if (!$actividad) {
            return $this->json(['error' => 'Actividad no encontrada'], Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializeActividad($actividad);
        return $this->json($data);
    }

    private function serializeActividad(Actividad $actividad): array
    {
        $data = [
            'id' => $actividad->getId(),
            'descripcion' => $actividad->getDescripcion(),
            'fechaHoraInicio' => $actividad->getFechaHoraIni()->format('d-m-Y H:i:s'),
            'fechaHoraFin' => $actividad->getFechaHoraFin()->format('d-m-Y H:i:s'),
            'tipo' => $actividad->getTipo(),
            'evento' => $actividad->getEvento() ? [
                'id' => $actividad->getEvento()->getId(),
                'titulo' => $actividad->getEvento()->getTitulo()
            ] : null,
        ];

        if ($actividad->getDetalleActividads()) {
            $subactividades = [];
            foreach ($actividad->getDetalleActividads() as $subactividad) {
                $subactividades[] = [
                    'id' => $subactividad->getId(),
                    'titulo' => $subactividad->getTitulo(),
                    'fechaHoraInicio' => $subactividad->getFechaHoraIni()->format('d-m-Y H:i:s'),
                    'fechaHoraFin' => $subactividad->getFechaHoraFin()->format('d-m-Y H:i:s'),
                    'espacio' => $subactividad->getEspacio() ? [
                        'id' => $subactividad->getEspacio()->getId(),
                        'nombre' => $subactividad->getEspacio()->getNombre()
                    ] : null,
                ];
            }
            $data['subactividades'] = $subactividades;
        }

        return $data;
    }

    #[Route('/actividades', name: 'actividad_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['tipo'])) {
            return $this->json(['error' => 'Tipo no especificado'], Response::HTTP_BAD_REQUEST);
        }

        $em->beginTransaction();
        try {
            if ($data['tipo'] == 1) {
                if (!isset($data['descripcion']) || !isset($data['fechaInicio']) || !isset($data['fechaFin'])) {
                    return $this->json(['error' => 'Datos incompletos para actividad'], Response::HTTP_BAD_REQUEST);
                }

                $fechaInicio = new \DateTime($data['fechaInicio']);
                $fechaFin = new \DateTime($data['fechaFin']);

                $actividad = new Actividad();
                $actividad->setDescripcion($data['descripcion']);
                $actividad->setFechaHoraIni($fechaInicio);
                $actividad->setFechaHoraFin($fechaFin);
                $actividad->setTipo($data['tipo']);

                if (isset($data['evento'])) {
                    $evento = $em->getRepository(Evento::class)->find($data['evento']);
                    if (!$evento) {
                        return $this->json(['error' => 'Evento no encontrado'], Response::HTTP_NOT_FOUND);
                    }
                    $actividad->setEvento($evento);
                }

                $em->persist($actividad);
                $em->flush();

                $detalleActividad = new DetalleActividad();
                $detalleActividad->setTitulo($data['descripcion']);
                $detalleActividad->setFechaHoraIni($fechaInicio);
                $detalleActividad->setFechaHoraFin($fechaFin);
                
                $detalleActividad->setURL($data['url'] ?? '');

                $detalleActividad->setActividad($actividad);

                if (isset($data['espacio'])) {
                    $espacio = $em->getRepository(Espacio::class)->find($data['espacio']);
                    if (!$espacio) {
                        return $this->json(['error' => 'Espacio no encontrado'], Response::HTTP_NOT_FOUND);
                    }
                    $detalleActividad->setEspacio($espacio);
                }

                $em->persist($detalleActividad);
                $em->flush();

                if (isset($data['ponentes'])) {
                    $this->updatePonentes($em, $detalleActividad, $data['ponentes']);
                }

                $em->commit();

                return $this->json([
                    'id' => $actividad->getId(),
                    'descripcion' => $actividad->getDescripcion(),
                    'fechaHoraInicio' => $actividad->getFechaHoraIni()->format('d-m-Y H:i:s'),
                    'fechaHoraFin' => $actividad->getFechaHoraFin()->format('d-m-Y H:i:s'),
                ], Response::HTTP_CREATED);
            } 
            elseif ($data['tipo'] == 2) 
            {
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
                $actividad->
                setEvento($evento);

                $em->persist($actividad);
                $em->flush();

                $em->commit();

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
            $em->rollback();
            return $this->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function updatePonentes(EntityManagerInterface $em, DetalleActividad $detalleActividad, array $ponentesData)
    {
        // Verificar si $ponentesData es un array
        if (!is_array($ponentesData)) {
            throw new \InvalidArgumentException('Los datos de los ponentes deben ser proporcionados como un array.');
        }

        // Verificar si $ponentesData tiene la estructura esperada
        foreach ($ponentesData as $ponenteData) {
            if (!isset($ponenteData['nombre']) || !isset($ponenteData['cargo']) || !isset($ponenteData['url'])) {
                throw new \InvalidArgumentException('Los datos de cada ponente deben incluir "nombre", "cargo" y "url".');
            }
        }
        
        $ponenteRepository = $em->getRepository(Ponente::class);
        
        try {
            // Eliminar ponentes existentes de la subactividad
            $ponentesExistentes = $ponenteRepository->findBy(['ponente_detalle_actividad' => $detalleActividad]);
            foreach ($ponentesExistentes as $ponenteExistente) {
                $em->remove($ponenteExistente);
            }
            $em->flush(); // Asegurarse de eliminar los ponentes anteriores antes de añadir los nuevos

            // Añadir nuevos ponentes
            foreach ($ponentesData as $ponenteData) {
                $ponente = new Ponente();
                $ponente->setNombre($ponenteData['nombre']);
                $ponente->setCargo($ponenteData['cargo']);
                $ponente->setURL($ponenteData['url']);
                $ponente->setPonenteDetalleActividad($detalleActividad);

                $em->persist($ponente);
            }

            $em->flush(); // Guardar los nuevos ponentes
        } catch (\Exception $e) {
            throw $e; // Re-lanzar la excepción para que el controlador pueda manejarla
        }
    }

}
