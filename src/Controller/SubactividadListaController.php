<?php
// src/Controller/SubactividadListaController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DetalleActividad;
use App\Repository\ActividadRepository;
use App\Repository\DetalleActividadRepository;

class SubactividadListaController extends AbstractController
{
    #[Route('/actividad/{id}', name: 'detalle_actividad', methods: ['GET'])]
    public function detalleActividad(int $id, DetalleActividadRepository $detalleActividadRepository, ActividadRepository $actividadRepository): Response
    {
        $actividad = $actividadRepository->find($id);

        if (!$actividad) {
            throw $this->createNotFoundException('Actividad no encontrada');
        }

        $subactividades = $detalleActividadRepository->findBy(['id_padre' => $id]);

        return $this->render('actividades/subactividades.html.twig', [
            'actividad' => $actividad,
            'subactividades' => $subactividades,
        ]);
    }
}
