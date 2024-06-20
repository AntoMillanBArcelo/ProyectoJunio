<?php
namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface; 
use Symfony\Component\Mime\Email;
use App\Service\pdfService; 
use App\Repository\DetalleActividadRepository;
use App\Repository\ActividadRepository;
use App\Repository\PonenteRepository;

class PdfController extends AbstractController
{
    #[Route('/pdf/{id}', name: 'app_pdf')]
public function generatePdf(int $id, DetalleActividadRepository $detalleActividadRepository, ActividadRepository $actividadRepository, PonenteRepository $ponenteRepository): Response
{
    $actividad = $actividadRepository->find($id);

    if (!$actividad) {
        throw $this->createNotFoundException('Actividad no encontrada');
    }

    $subactividades = $detalleActividadRepository->findBy(['id_padre' => $id]);

    $ponentesPorSubactividad = [];
    foreach ($subactividades as $subactividad) {
        $ponentesPorSubactividad[$subactividad->getId()] = $ponenteRepository->findBy(['ponenteDetalleActividad' => $subactividad]);
    }

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);

    $html = $this->renderView('pdf/pdf.html.twig', [
        'actividad' => $actividad,
        'subactividades' => $subactividades,
        'ponentesPorSubactividad' => $ponentesPorSubactividad,
    ]);

    $dompdf->loadHtml($html);
    $dompdf->render();

    return new Response(
        $dompdf->output(),
        Response::HTTP_OK,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="detalle_actividad.pdf"',
        ]
    );
}



    #[Route('/pdfcorreo', name: 'app_pdfcorreo')]
    public function enviarPdf(MailerInterface $mailer): Response 
    {

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $html = $this->renderView('pdf/pdf.html.twig');

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfContent = $dompdf->output();

        $email = (new Email())
            ->from('amilbar961@g.educaand.es')
            ->to('millanbarceloa@gmail.com')
            ->subject('PDF Adjunto')
            ->text('Se adjunta el PDF generado.')
            ->attach($pdfContent, 'document.pdf');

        $mailer->send($email); 

        return new Response('PDF enviado por correo electrónico.');
        
    }

    #[Route('/pdfservicio', name: 'app_pdfservicio')]
    public function PdfServicio(pdfService $pdfService): Response
    {

        $htmlContent = $this->renderView('pdf/pdf.html.twig', [
            'name' => 'PDF servicio',
        ]);

        return $pdfService->generatePdf($htmlContent);
    }
    
}
