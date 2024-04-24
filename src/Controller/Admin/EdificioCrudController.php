<?php

namespace App\Controller\Admin;

use App\Entity\Edificio;
use App\Form\EdificioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EdificioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Edificio::class;
    }
}

