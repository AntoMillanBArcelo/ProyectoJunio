<?php

namespace App\Controller;

use App\Entity\Actividad;
use App\Entity\DetalleActividad;
use App\Repository\PonenteRepository;
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
    public function index(PonenteRepository $ponenteRepository): Response 
    {
        $detalleactividades = $this->entityManager
            ->getRepository(DetalleActividad::class)
            ->findBy(['id_padre' => null]);

        $ponentesPorSubactividad = [];
        foreach ($detalleactividades as $detalleactividad) {
            $ponentesPorSubactividad[$detalleactividad->getId()] = $ponenteRepository->findBy(['ponenteDetalleActividad' => $detalleactividad]);
        }

        $actividades = $this->entityManager
            ->getRepository(Actividad::class)
            ->findBy(['id_padre' => null]);

        return $this->render('actividades/todasactividades.html.twig', [
            'actividades' => $actividades,
            'detalleactividades' => $detalleactividades,
            'ponentesPorSubactividad' => $ponentesPorSubactividad,
        ]);
    }
}
