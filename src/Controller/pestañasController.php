<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class pestañasController extends AbstractController
{
    #[Route('/actividad', name: 'app_pestañas')]
    public function index(): Response
    {
        return $this->render('pestañas/pestañas.html.twig');
    }
} 
