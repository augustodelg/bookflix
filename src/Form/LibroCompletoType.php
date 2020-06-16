<?php

namespace App\Form;

use App\Entity\CapituloLibro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LibroCompletoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('archivoFile', VichFileType::class, array(
            'label' => "SELECCIONE EL PDF",
            'required' => false )
            )
        ->add('fechaDisponible', DateType::class )
        ->add('fechaVencimiento', DateType::class )
        ->add('guardarCompleto', SubmitType::class ,['label' => 'Guardar'] );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CapituloLibro::class,
        ]);
    }
}
