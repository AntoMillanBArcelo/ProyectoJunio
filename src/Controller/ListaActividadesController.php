<?php

namespace App\Controller;

use App\Repository\EventoRepository;
use App\Repository\ActividadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListaActividadesController extends AbstractController
{
    #[Route('/evento/{id}/actividades', name: 'evento_actividades')]
    public function actividadesDelEvento(int $id, EventoRepository $eventoRepository, ActividadRepository $actividadRepository): Response
    {
        // Obtener el evento por su ID
        $evento = $eventoRepository->find($id);

        // Obtener las actividades relacionadas con el evento
        $actividades = $actividadRepository->findBy(['evento' => $evento]);

        // Obtener una lista de todas las imágenes en la carpeta de imágenes
        $images = glob('images/actividades/*');

        // Seleccionar una imagen aleatoria de la lista
        $randomImage = $images[array_rand($images)];

        return $this->render('actividades/actividades.html.twig', [
            'actividades' => $actividades,
            'random_image' => $randomImage,
        ]);
    }
}
