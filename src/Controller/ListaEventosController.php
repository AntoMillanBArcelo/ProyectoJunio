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
        // Obtener todos los eventos desde la base de datos
        $eventos = $eventoRepository->findAll();

        // Calcular días restantes y determinar si el evento ha terminado
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

        // Renderizar la plantilla pasando los eventos con días restantes y estado
        return $this->render('eventos/eventos.html.twig', [
            'eventosConDiasRestantes' => $eventosConDiasRestantes,
        ]);
    }
}
