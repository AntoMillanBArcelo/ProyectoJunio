<?php
// src/Controller/ActividadController.php

namespace App\Controller;

use App\Entity\DetalleActividad;
use App\Repository\DetalleActividadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ActividadController extends AbstractController
{
    #[Route('/actividad/{id}/subactividades', name: 'ver_subactividades')]
    public function verSubactividades(int $id, DetalleActividadRepository $detalleActividadRepository): JsonResponse
    {
        $subactividades = $detalleActividadRepository->findBy(['id_padre' => $id]);

        $subactividadesArray = array_map(function(DetalleActividad $detalleActividad) {
            return [
                'id' => $detalleActividad->getId(),
                'Titulo' => $detalleActividad->getTitulo(),
                'FechaHoraIni' => $detalleActividad->getFechaHoraIni()->format('Y-m-d H:i:s'),
                'FechaHoraFin' => $detalleActividad->getFechaHoraFin()->format('Y-m-d H:i:s'),
                'descripcion' => $detalleActividad->getDescripcion(),
            ];
        }, $subactividades);

        return new JsonResponse(['subactividades' => $subactividadesArray]);
    }
}
