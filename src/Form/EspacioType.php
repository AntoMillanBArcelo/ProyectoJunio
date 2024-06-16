<?php

namespace App\Form;

use App\Entity\Espacio;
use App\Entity\Recurso;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EspacioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre')
            ->add('Aforo')
            ->add('espacio_edificio')
            ->add('recursos', EntityType::class, [
                'class' => Recurso::class,
                'choice_label' => 'Descripcion',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false, // Este es el punto clave
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Espacio::class,
        ]);
    }
}
