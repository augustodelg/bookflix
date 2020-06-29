<?php

namespace App\Form;

use App\Entity\CalificacionComentario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;




class CalificacionComentarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calificacion',ChoiceType::class,[
                'choices'=> [
                    '1'=> 1,
                    '2'=> 2,
                    '3'=> 3,
                    '4'=> 4,
                    '5'=> 5,
                    ]])
            ->add('texto', TextareaType::class,['required' => false,])
            ->add('spoiler',CheckboxType::class,['required' => false,])
            ->add('comentar',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CalificacionComentario::class,
        ]);
    }
}
