<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Validator\ValidatorInterface;   
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Cuenta;
use App\Entity\Tarjeta;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CuentaController extends AbstractController
{
    /**
     * @Route("/modificar-cuenta", name="modificar-cuenta")
     */
    public function index(Request $request , ValidatorInterface $validator , UserPasswordEncoderInterface $passwordEncoder )
    {
        $user = $this->getUser();
        $email = $user->getEmail();
        $nombre = $user->getNombre();
        $apellido = $user->getApellido();
        $password = $user->getPassword();
        $tarjeta = $user->getTarjeta();
        $numero = $tarjeta->getNumero();
        $cvv = $tarjeta->getCvv();
        $dni = $tarjeta->getDni();
        $vencimiento = $tarjeta->getVencimiento();
        $newDate = $vencimiento->format('Y-m-d');

        $defaultData = array('');
        $formMod = $this->createFormBuilder($defaultData)
            ->add('email', EmailType::class, [ 'required' => false]//, 'empty_data' => $email, ]
            )
            ->add('nombre',TextType::class, [ 'required' => false]//, 'empty_data' => $nombre, ]
            )         
            ->add('apellido',TextType::class, [ 'required' => false]//, 'empty_data' => $apellido, ]
            )
            ->add('password', PasswordType::class, [ 'required' => false]//, 'empty_data' => $password, ]
            )
            ->add('numero',null, [ 'required' => false]//, 'empty_data' => $tarjeta, ]
            )
            ->add('cvv', NumberType::class, [ 'required' => false]//, 'empty_data' => $cvv, ]
            )
            ->add('dni',null, [ 'required' => false]//, 'empty_data' => $dni, ]
            )
            ->add('vencimiento',DateType::class, [ 'required' => false]
            )
            ->add('Modificar',SubmitType::class)
            ->getForm();
        $formMod->handleRequest($request);


        if ($formMod->isSubmitted() && $formMod->isValid()){
            

            $em = $this->getDoctrine()->getManager();

            

            

            $data = $formMod->getData();
            $errors=null;

            if ($data['vencimiento']!=null){
                $tarjeta->setVencimiento($data['vencimiento']);

                $errors = $validator->validate($tarjeta);
            }


            //----------VALIDACIONES-----------

            if ($data['email']!=null){
                $emailString = (string)$data['email'];   //CONVIERTO EMAIL A STRING PARA PODER COMPARAR 
                $validarEmail = $em->getRepository(Cuenta::class)->findOneBy(['email' => $emailString]);
                if (empty($validarEmail)){
                    $user->setEmail($data['email']);
                    $em->persist($user);
                    $em->flush();
                }else{
                    $this->addFlash('error','El email ya esta en uso!');
                    return $this->render('cuenta/error.html.twig');
                }                
            }

            if ($data['nombre']!=null){
                $nom=(string)$data['nombre'];
                if (preg_match('/[0-9]{1}/',$nom)){
                    $this->addFlash('error','El nombre solo debe contener letras!');
                    return $this-> render('cuenta/error.html.twig');
                }else{
                    $user->setNombre($data['nombre']);
                    $em->persist($user);
                    $em->flush();
                }
            }

            if ($data['apellido']!=null){
                $ap=(string)$data['apellido'];
                if (preg_match('/[0-9]{1}/',$ap)){
                    $this->addFlash('error','El apellido solo debe contener letras!');
                    return $this-> render('cuenta/error.html.twig');
                }else{
                    $user->setApellido($data['apellido']);
                    $em->persist($user);
                    $em->flush();
                }
            }

            if ($data['password']!=null){
                $user->setPassword($passwordEncoder->encodePassword($user,$data['password']));
                $em->persist($user);
                $em->flush();
            }

            if ($data['numero']!=null){
                if ($tarjeta->getCant($data['numero']) != 16){
                    $this->addFlash('error','El numero de tarjeta no es valido!');
                    return $this-> render('cuenta/error.html.twig');
                }else{
                    $tarjeta->setNumero($data['numero']);
                    $em->persist($tarjeta);
                    $em->flush();
                }
            }

            if ($data['cvv']!=null){
                if ($tarjeta->getCant($data['cvv']) != 3){
                    $this->addFlash('error','El cvv de la tarjeta debe contener 3 digitos!');
                    return $this-> render('cuenta/error.html.twig');
                }else{
                    $tarjeta->setCvv($data['cvv']);
                    $em->persist($tarjeta);
                    $em->flush();
                }
            }


            if ($data['dni']!=null){
                $dniTarjeta = (string)$data['dni'];

                $validarDni = $em->getRepository(Tarjeta::class)->findOneBy(['dni' => $dniTarjeta]);
    
                if (!empty($validarDni)){
                    $this->addFlash('error','La tarjeta ya esta en uso!');
                    return $this-> render('cuenta/error.html.twig');
                }else{
                    $tarjeta->setDni($data['dni']);
                    $em->persist($tarjeta);
                    $em->flush();
                }
            }



            if ($errors!=null){

                if (count($errors) > 0){
                    $this->addFlash('error','La tarjeta esta vencida!');
                    return $this-> render('cuenta/error.html.twig');
                }else{
                    $tarjeta->setVencimiento($data['vencimiento']);
                    $em->persist($tarjeta);
                    $em->flush();
                }
            }

            // $em->persist($tarjeta);
            // $em->flush();
            // $em->persist($user);
            // $em->persist($tarjeta);
            
            return new RedirectResponse('/perfil'); 
            


            

        }
        $defaultData = ['mensaje' => 'Busque su libro aqui'];
        $form = $this->createFormBuilder($defaultData)
            ->add('textoBusqueda', TextType::class)
             ->add('ElegirCriterio', ChoiceType::class,[
                'choices'=> [
                    'Autor'=>'autor',
                    'Genero'=>'genero',
                    'Editorial'=>'editorial',
                    'Titulo'=>'titulo',
                    ],
                ])
        ->add('Buscar',SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
           $busqueda = $form->getData();
            return $this->redirectToRoute('buscando_libro',[
                'texto'=>$busqueda['textoBusqueda'],
                'criterio'=>$busqueda['ElegirCriterio']
                ]);
            }

        //Obtener perfil actual
        $user = $this->getUser();
        $perfiles = $user->getPerfiles();
        $perfil = $user->getPerfilActivo();

        $perfilActivo = $perfiles[$perfil];

        return $this->render('cuenta/index.html.twig', [
            'formulario' => $formMod->createView(),
            'myForm' => $form->createView(),
            'perfilActivo' => $perfilActivo,
        ]);
    }
}
