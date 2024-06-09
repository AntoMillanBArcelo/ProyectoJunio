<?php
// src/Controller/CustomErrorController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CustomErrorController extends AbstractController
{
    public function show(): Response
    {
        return $this->render('error/not_found.html.twig');
    }
}

