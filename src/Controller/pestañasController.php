<?php
// src/Controller/pestañasController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actividad;
use App\Entity\Evento;
use Doctrine\ORM\EntityManagerInterface;

class pestañasController extends AbstractController
{
    #[Route('/actividad', name: 'app_pestañas', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $actividad = new Actividad();
            
            $actividad->setTipo($request->request->get('actividad'));
            $actividad->setDescripcion($request->request->get('descripcion'));
            $actividad->setFechaHoraIni(new \DateTime($request->request->get('inicio')));
            $actividad->setFechaHoraFin(new \DateTime($request->request->get('fin')));

            $eventoId = $request->request->get('evento');
            if ($eventoId) {
                $evento = $entityManager->getRepository(Evento::class)->find($eventoId);
                $actividad->setEvento($evento);
            }

            $entityManager->persist($actividad);
            $entityManager->flush();

            $this->addFlash('success', 'Actividad añadida exitosamente!');

            return $this->redirectToRoute('app_pestañas');
        }

        return $this->render('pestañas/pestañas.html.twig');
    }
}
