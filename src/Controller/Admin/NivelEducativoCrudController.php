<?php

namespace App\Controller\Admin;

use App\Entity\NivelEducativo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class NivelEducativoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NivelEducativo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), 
            TextField::new('nombre', 'Nombre del Nivel Educativo'), 
            AssociationField::new('grupo', 'Grupo'), 
        ];
    }
}

