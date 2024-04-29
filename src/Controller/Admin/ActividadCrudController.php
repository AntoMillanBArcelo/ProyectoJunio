<?php

namespace App\Controller\Admin;

use App\Entity\Actividad;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActividadCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actividad::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Oculta el campo ID en el formulario
            DateTimeField::new('fecha_hora_ini', 'Fecha y Hora de Inicio'), // Campo para la fecha y hora de inicio
            DateTimeField::new('fecha_hora_fin', 'Fecha y Hora de Fin'), // Campo para la fecha y hora de fin
            AssociationField::new('evento', 'Evento'), // Campo para la asociación con Evento
            
        ];
    }
}
