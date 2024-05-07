<?php

namespace App\Controller\Admin;

use App\Entity\Edificio;
use App\Entity\Espacio;
use App\Entity\Recurso;
use App\Entity\User;
use App\Entity\DetalleActividad;
use App\Entity\Evento;
use App\Entity\Actividad;
use App\Entity\Ponente;
use App\Entity\Alumno;
use App\Entity\Grupo;
use App\Entity\NivelEducativo;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/easyadmin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administración');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Espacios');
        yield MenuItem::linkToCrud('Edificio', 'fa-solid fa-building', Edificio::class);
        yield MenuItem::linkToCrud('Espacio', 'fa-solid fa-person-shelter', Espacio::class);
        yield MenuItem::linkToCrud('Recurso', 'fa-solid fa-desktop', Recurso::class);
        yield MenuItem::linkToCrud('User', 'fa-solid fa-desktop', User::class);

        yield MenuItem::section('Eventos');
        yield MenuItem::linkToCrud('Detalle Actividad', 'fa-solid fa-desktop', DetalleActividad::class);
        yield MenuItem::linkToCrud('Actividad', 'fa-solid fa-desktop', Actividad::class);
        yield MenuItem::linkToCrud('Evento', 'fa-solid fa-desktop', Evento::class);
        yield MenuItem::linkToCrud('Ponente', 'fa-solid fa-desktop', Ponente::class);

        
        yield MenuItem::section('Alumnos');
        yield MenuItem::linkToCrud('Alumno', 'fa-solid fa-desktop', Alumno::class);
        yield MenuItem::linkToCrud('Nivel Educativo', 'fa-solid fa-desktop', NivelEducativo::class);
        yield MenuItem::linkToCrud('Grupo', 'fa-solid fa-desktop', Grupo::class);

        yield MenuItem::linkToRoute('s', 'fa-solid fa-desktop', 'cargar');
        yield MenuItem::linkToUrl('sUrl', 'fa-solid fa-desktop', $this->generateUrl('cargar'));
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
