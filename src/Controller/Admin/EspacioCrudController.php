<?php

namespace App\Controller\Admin;

use App\Entity\Espacio;
use App\Form\EspacioType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;

class EspacioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Espacio::class;
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
                ->setHelp('Seleccione los recursos asociados a este espacio'),
        ];
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $entityInstance = $this->getDoctrine()->getRepository(Espacio::class)->find($entityDto->getPrimaryKeyValue());

        return parent::createEditFormBuilder($entityDto, $formOptions, $context)
            ->setAction($context->getAction()->getFormAction())
            ->add('Nombre')
            ->add('Aforo')
            ->add('espacio_edificio')
            ->add('recursos', EntityType::class, [
                'class' => \App\Entity\Recurso::class,
                'choice_label' => 'Descripcion',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false,
            ]);
    }
}
