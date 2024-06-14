<?php
// src/Controller/ListaActividadesController.php
namespace App\Controller;

use App\Repository\EventoRepository;
use App\Repository\ActividadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Evento;
use App\Entity\Actividad;

class ListaActividadesController extends AbstractController

{#[Route('/evento/{id}/actividades', name: 'evento_actividades')]
public function actividadesDelEvento(int $id, EventoRepository $eventoRepository, ActividadRepository $actividadRepository): Response
{
    $evento = $eventoRepository->find($id);

        if (!$evento) {
            throw $this->createNotFoundException('Evento no encontrado');
        }

        $actividades = $actividadRepository->findBy(['evento' => $evento]);

        $images = glob('images/actividades/*');
        shuffle($images);

        return $this->render('actividades/actividades.html.twig', [
            'actividades' => $actividades,
            'random_images' => $images,
        ]);
}

    #[Route('/actividad/{id}/descargar', name: 'actividad_descargar')]
    public function descargarActividad(int $id, ActividadRepository $actividadRepository): Response
    {
        $actividad = $actividadRepository->find($id);

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($pdfOptions);
       
        $html = $this->renderView('pdf/pdf.html.twig', [
            'actividad' => $actividad,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $response = new Response($output);

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="actividad.pdf"');

        return $response;
    }
}