<?php
// src/Service/pdfService.php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;

class pdfService
{
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    public function generatePdf(string $htmlContent): Response
    {
        
        $this->dompdf->loadHtml($htmlContent);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Render PDF
        $this->dompdf->render();

        // Return PDF as response
        return new Response(
            $this->dompdf->output(),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
