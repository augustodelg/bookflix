<?php

namespace App\Controller;

// use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form;
use App\Entity\Cuenta;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Tarjeta;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;


use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints\GreaterThan;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\Serializer\Encoder\JsonEncode;
// use Symfony\Component\Serializer\Encoder\JsonDecode;


class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro")
     */

    public function index(Request $request , ValidatorInterface $validator , UserPasswordEncoderInterface $passwordEncoder)
    {

   

        $defaultData = array('');
        $form = $this->createFormBuilder($defaultData)
            ->add('email', EmailType::class)
            ->add('nombre')            
            ->add('apellido')
            ->add('password', PasswordType::class)
            ->add('numero')
            ->add('cvv', NumberType::class)
            ->add('dni')
            ->add('vencimiento',DateType::class)
            ->add('Registrarse',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);


        $user = new Cuenta();
        $tarjeta = new Tarjeta();

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user->setEmail($data['email']);
            $user->setNombre($data['nombre']);
            $user->setApellido($data['apellido']);
            $user->setPassword($passwordEncoder->encodePassword($user,$data['password']));
            $user->setRoles(['ROLE_USER']);

            $num=(int)$data['numero']; //convierto string a int para setear el numero de tarjeta

            $tarjeta->setNumero($num);
            $tarjeta->setCvv($data['cvv']);
            $tarjeta->setDni($data['dni']);
            $tarjeta->setVencimiento($data['vencimiento']);
            $tarjeta->setCuenta($user);
            $user->setTarjeta($tarjeta);

            $errors = $validator->validate($tarjeta);

            //-----------------------VALIDACIONES-------------------------

            $email = (string)$data['email'];

            $validarEmail = $em->getRepository(Cuenta::class)->findOneBy(['email' => $email]);

            if (!empty($validarEmail)){
                $this->addFlash('error','El email ya esta en uso!');
                return $this-> render('registro/error.html.twig');
            }
            // $soloLetras="abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";


            // if (preg_match($soloLetras,$data['nombre'])==0){
            //     $this->addFlash('error','El nombre no puede tener numeros!');
            //     return $this-> render('registro/error.html.twig');
            // }

            if ($tarjeta->getCant($data['numero']) != 16){
                $this->addFlash('error','El numero de tarjeta no es valido!');
                return $this-> render('registro/error.html.twig');
            }
            if ($tarjeta->getCant($data['cvv']) != 3){
                $this->addFlash('error','El cvv de la tarjeta debe contener 3 digitos!');
                return $this-> render('registro/error.html.twig');
            }

            if (count($errors) > 0){
                $this->addFlash('error','La tarjeta esta vencida!');
                return $this-> render('registro/error.html.twig');
            }
            $em->persist($user);
            $em->persist($tarjeta);
            $em->flush();
            return new RedirectResponse('/login');            
        }
        return $this->render('registro/index.html.twig', [
        'formulario' => $form->createView(),
        ]);
    }
    }

