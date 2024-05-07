<?php

namespace App\Controller\Admin;

use App\Entity\Espacio;
use App\Entity\Edificio; 
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class EspacioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Espacio::class;
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
            TextField::new('Nombre', 'Nombre del Espacio'),
            IntegerField::new('Aforo', 'Aforo'), 
            AssociationField::new('espacio_edificio', 'Edificio'), 
            AssociationField::new('recursos', 'Recursos')
                ->setFormTypeOption('class', 'App\Entity\Recurso')
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('required', true)
                ->setHelp('ayuda'),
        ];
    }
    
}
