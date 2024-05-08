<?php
namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface; // Importa el MailerInterface
use Symfony\Component\Mime\Email;
use App\Service\pdfService; 

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function generatePdf(): Response
    {
        
        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Genera el contenido HTML del PDF utilizando la plantilla Twig
        $html = $this->renderView('pdf/pdf.html.twig', [
            'name' => 'esto es un mirlo',
        ]);

        // Carga el contenido HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderiza el PDF
        $dompdf->render();

        // Devuelve el PDF como una respuesta HTTP
        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }

    #[Route('/pdfcorreo', name: 'app_pdfcorreo')]
    public function enviarPdf(MailerInterface $mailer): Response // Inyecta MailerInterface
    {
        // Crear una instancia de Dompdf con algunas opciones
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Renderizar la plantilla Twig con contenido estático e imágenes
        $html = $this->renderView('pdf/pdf.html.twig');

        // Cargar el HTML en Dompdf y generar el PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $pdfContent = $dompdf->output();

        // Envía el PDF como un correo electrónico
        $email = (new Email())
            ->from('your_email@example.com')
            ->to('mr.charmander62@gmail.com')
            ->subject('PDF Adjunto')
            ->text('Se adjunta el PDF generado.')
            ->attach($pdfContent, 'document.pdf');

        $mailer->send($email); // Aquí está inyectando $mailer

        // Devolver una respuesta
        return new Response('PDF enviado por correo electrónico.');
    }

    //Servicio de correos
    #[Route('/pdfservicio', name: 'app_pdfservicio')]
    public function PdfServicio(pdfService $pdfService): Response
    {

        $htmlContent = $this->renderView('pdf/pdf.html.twig', [
            'name' => 'PDF servicio',
        ]);

        return $pdfService->generatePdf($htmlContent);
    }
}
