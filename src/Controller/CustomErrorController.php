<?php
// src/Controller/CustomErrorController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomErrorController extends AbstractController
{
    #[Route('/{any}', name: 'not_found')]
    public function notFound(): Response
    {
        return $this->render('error/not_found.html.twig');
    }

    #[Route('/{any}', name: 'handle_wildcard')]
    public function handleWildcard(): Response
    {
        return $this->render('error/not_found.html.twig');
    }
}
