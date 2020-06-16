<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BuscarLibroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
        ->add('nombreLibroBuscado', TextType::class)
        ->add('ElegirCriterio', ChoiceType::class,[
            'choices'=> [
                'Autor'=>'autor',
                'Genero'=>'genero',
                'Editorial'=>'editorial',
                'Titulo'=>'titulo',

            ],
        ])
        ->add('Buscar',SubmitType::class);
    }
}