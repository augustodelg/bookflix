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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Tarjeta;


use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintViolationList;
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
            ->add('numero', NumberType::class)
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
            //$dataTarjeta = $formTarjeta->getData(); 
            $em = $this->getDoctrine()->getManager();
            $user->setEmail($data['email']);
            $user->setNombre($data['nombre']);
            $user->setApellido($data['apellido']);
            $user->setPassword($passwordEncoder->encodePassword($user,$data['password']));
            $user->setRoles(['ROLE_USER']);
            $tarjeta->setNumero($data['numero']);
            $tarjeta->setCvv($data['cvv']);
            $tarjeta->setDni($data['dni']);
            $tarjeta->setVencimiento($data['vencimiento']);
            $user->setTarjeta($tarjeta);
            $tarjeta->setCuenta($user);

            $errors = $validator->validate($tarjeta);

            if (count($errors) > 0) {

                return $this->render('registro/index.html.twig', [
                    'errors' => $errors,
                    'formulario' => $form->createView()
                ]);


                // $messages = [];
                // foreach ($errors as $violation) {
                //     $messages[$violation->getPropertyPath()][] = $violation->getMessage();
                //     $this->addFlash('mensaje',$errors);
                //     return new RedirectResponse('/registro');
                // }

                // return new JsonResponse($messages);
                
                //$errorsString = (string) $errors;
             
                
            }else{
                $em->persist($user);
                $em->persist($tarjeta);
                $em->flush();
                $this->addFlash('mensaje','Se ha registrado exitosamente!');
                return new RedirectResponse('/login');
            }

        }else{
            return $this->render('registro/index.html.twig', [
                'formulario' => $form->createView(),
                'errors' => $errors
            ]);
        }

    }
}
