<?php

namespace App\Controller;

use App\Entity\Actividad;
use App\Entity\DetalleActividad;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListaTodasActividades extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/todasactividades', name: 'todas_actividades')]
    public function index(): Response 
    {
        $detalleactividad = $this->entityManager
            ->getRepository(DetalleActividad::class)
            ->findBy(['id_padre' => null]);

        $actividades = $this->entityManager
            ->getRepository(Actividad::class)
            ->findBy(['id_padre' => null]);

        return $this->render('actividades/todasactividades.html.twig', [
            'actividades' => $actividades,
            'detalleactividades' => $detalleactividad,
        ]);
    }
}
