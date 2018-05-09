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
                    'pattern' => '(.){30}'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo Electronico',
                'required' => true,
                'pattern' => '((.+)@(.+)\.(.+)){60}'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_option' => [
                    'label' => 'Contraseña'
                ],
                'second_option' => [
                    'label' => 'Repetir contraseña'
                ]
            ])
            ->add('telefono', TextType::class, [
                'label' => 'Telefono',
                'attr' => [
                    'pattern' => '(\+[0-9]{,3}\ )?[0-9]{,9}'
                ]
            ])
            ->add('empresa', TextType::class, [
                'label' => 'Empresa',
                'attr' => [
                    'pattern' => '.{30}'
                ]
            ])
            ->add('sector', TextType::class, [
                'label' => 'Sector',
                'attr' => [
                    'pattern' => '.{30}'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

}