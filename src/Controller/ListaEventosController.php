<?php
// src/Controller/ListaEventosController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventoRepository;
use DateTime;

class ListaEventosController extends AbstractController
{
    #[Route('/eventos', name: 'eventos_index')]
    public function index(EventoRepository $eventoRepository): Response
    {

        $eventos = $eventoRepository->findAll();

        $eventosConDiasRestantes = [];
        foreach ($eventos as $evento) {
            $fechaFin = $evento->getFechaFin();
            $hoy = new DateTime();
            $interval = $hoy->diff($fechaFin);
            $diasRestantes = $interval->invert ? -$interval->days : $interval->days;
            $haTerminado = $fechaFin < $hoy;

            $eventosConDiasRestantes[] = [
                'evento' => $evento,
                'diasRestantes' => $diasRestantes,
                'haTerminado' => $haTerminado,
            ];
        }

        return $this->render('eventos/eventos.html.twig', [
            'eventosConDiasRestantes' => $eventosConDiasRestantes,
        ]);
    }
}
