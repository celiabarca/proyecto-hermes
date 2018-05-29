<?php

/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 8/05/18
 * Time: 19:27
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nombre', TextType::class, [
                    'label' => 'Nombre de usuario',
                    'required' => true,
                    'attr' => [
                        'class' => 'username'
                    ]
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Correo Electronico',
                    'required' => true,
                    'attr' => [
                        'class' => 'email'
                    ]
                ])
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'required' => true,
                    'first_options' => [
                        'label' => 'Contraseña',
                        'attr' => [
                            'class' => 'passwd'
                        ],
                    ],
                    'second_options' => [
                        'label' => 'Repetir contraseña',
                        'attr' => [
                            'class' => 'passwd'
                        ]
                    ]
                ])
                ->add('telefono', TextType::class, [
                    'label' => 'Telefono',
                    'required' => false,
                    'attr' => [
                        'class' => 'telefono'
                    ]
                ])
                ->add('empresa', TextType::class, [
                    'label' => 'Empresa',
                    'required' => false,
                    'attr' => [
                        'class' => 'company'
                    ]
                ])
                ->add('sector', TextType::class, [
                    'label' => 'Sector',
                    'required' => false,
                    'attr' => [
                        'class' => 'sector'
                    ]
                ])
                ->add('registrarse', SubmitType::class, [
                    'label' => 'Registrarme'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

}
