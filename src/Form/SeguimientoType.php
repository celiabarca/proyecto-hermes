<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 14/05/18
 * Time: 17:57
 */

namespace App\Form;


use App\Entity\Seguimiento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeguimientoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('situacion', TextType::class, [
                'label' => 'Situacion del proyecto'
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripcion de la situacion'
            ])
            ->add('enviar', SubmitType::class, [
                'label' => 'Enviar nueva situacion'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Seguimiento::class
        ]);
    }

}