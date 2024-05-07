<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CargarController extends AbstractController
{
    #[Route('/cargar', name: 'cargar')]
    public function index(): Response
    {
        return $this->render('cargar.html.twig');
    }
}
