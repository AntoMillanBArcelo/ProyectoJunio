<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actividad;
use App\Repository\ActividadRepository;

class ActividadBucle extends AbstractController
{
    #[Route('/tablaActividad', name: 'app_actividadbucle')]
    public function listaActividad(ActividadRepository $Repository): Response
    {
        $actividades = $Repository->findAll();

        return $this->render('actividad.html.twig', [
            'actividades' => $actividades,
        ]);
    }
}
