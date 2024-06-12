<?php
// src/Controller/DetalleActividadBucle.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DetalleActividad;
use App\Entity\Actividad;
use App\Repository\DetalleActividadRepository;
use App\Repository\ActividadRepository;

class DetalleActividadBucle extends AbstractController
{
    #[Route('/tablaDetalleActividad', name: 'app_detalleactividadbucle')]
    public function listaDetalleActividad(DetalleActividadRepository $detalleActividadRepository, ActividadRepository $actividadRepository): Response
    {
        $actividades = $actividadRepository->findAll();

        return $this->render('actividad.html.twig', [
            'entities' => $actividades
        ]);
    }
}
