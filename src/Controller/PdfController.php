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

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function generatePdf(): Response
    {
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = $this->renderView('pdf/pdf.html.twig', [
            'name' => 'esto es un mirlo',
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
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
            ->from('your_email@example.com')
            ->to('mr.charmander62@gmail.com')
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
