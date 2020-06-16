<?php

namespace App\Form;

use App\Entity\CapituloLibro;
use App\Entity\Libro;
use App\Form\CapituloType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class LibroPorCapitulosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('capituloLibros', CollectionType::class, 
            [
                'entry_type' => CapituloType::class,'prototype' => true, 'entry_options' => ['label' => false] ,'allow_add' => true,'allow_delete' => false, 'by_reference' => false]
            )
            ->add('completo', CheckboxType::class, ['label' => 'Libro completo','required' => false,])
            ->add('save', SubmitType::class ,['label' => 'Confirmar'] )->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Libro::class,
        ]);
    }

}
