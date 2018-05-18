<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 17/05/18
 * Time: 16:43
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditarUsuarioType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('img', FileType::class, [
                'label' => 'Foto de perfil',
                'required' => false,
                'data' => null
            ])
            ->add('nombre', TextType::class, [
                'label' => 'Nombre de usuario',
                'required' => false,
                'attr' => [
                    'class' => 'username'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo Electronico',
                'required' => false,
                'attr' => [
                    'class' => 'email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'first_options' => [
                    'required' => false,
                    'label' => 'Contraseña'
                ],
                'second_options' => [
                    'label' => 'Repetir contraseña',
                    'required' => false,
                    'attr' => [
                        'class' => 'passwd'
                    ]
                ],
                'attr' => [
                    'class' => 'passwd'
                ]
            ])
            ->add('telefono', TextType::class, [
                'label' => 'Telefono',
                'required' => false,
                'attr' => [
                    'class' => 'phone'
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
            ->add('editar', SubmitType::class, [
                'label' => 'Editar'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

}