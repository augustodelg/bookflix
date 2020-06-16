<?php

namespace App\Form;

use App\Entity\CapituloLibro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class CapituloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nro')
            ->add('archivoFile', VichFileType::class, array(
                'label' => "SELECCIONE EL PDF",
                'required' => false )
                )
            ->add('fechaDisponible', DateType::class)
            ->add('fechaVencimiento', DateType::class)
            ->add('completo', CheckboxType::class, ['label' => 'Ultimo capitulo','required' => false, 'mapped' => false])
            ->add('save', SubmitType::class ,['label' => 'Guardar'] );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CapituloLibro::class,
        ]);
    }
}
