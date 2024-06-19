<?php

namespace App\Controller\Api;

use App\Entity\DetalleActividad;
use App\Entity\Grupo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetalleActividadGrupoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/API/detalle_actividad_grupo', name: 'guardar_detalle_actividad_grupo', methods: ['POST'])]
    public function guardar(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $actividadId = $data['actividadId'];
        $grupoIds = $data['grupos'];

        $actividad = $this->entityManager->getRepository(DetalleActividad::class)->find($actividadId);

        if (!$actividad) {
            return new Response('Actividad no encontrada', Response::HTTP_NOT_FOUND);
        }

        foreach ($grupoIds as $grupoId) {
            $grupo = $this->entityManager->getRepository(Grupo::class)->find($grupoId);

            if ($grupo) {
                $actividad->addGrupo($grupo);
            }
        }

        $this->entityManager->persist($actividad);
        $this->entityManager->flush();

        return $this->json(['message' => 'Grupos asociados a la actividad exitosamente'], Response::HTTP_CREATED);
    }
}
