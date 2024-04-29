<?php
namespace App\Controller\Admin;

use App\Entity\Alumno;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class AlumnoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Alumno::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->disable(Action::DETAIL); 
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), 
            TextField::new('nombre', 'Nombre del Alumno'),
            TextField::new('correo', 'Correo del Alumno'), 
            DateField::new('fecha_nac', 'Fecha de Nacimiento'), 
            AssociationField::new('alumno_grupo', 'Grupo') 
        ];
    }
}
