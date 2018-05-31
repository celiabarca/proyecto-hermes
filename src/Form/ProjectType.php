<?php

namespace App\Form;

use App\Entity\Project;
use App\Type\TagInputType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class ProjectType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('titulo', TextType::class, [
                    'label' => 'Titulo'
                ])
                ->add('descripcion', TextareaType::class, [
                    'label' => 'Descripcion'
                ])
                ->add('img', FileType::class, [
                    'required' => false,
                    'label' => 'Imagen',
                    'data' => null,
                ])
                ->add('contenido', TextareaType::class, [
                    'label' => 'Sobre el proyecto'
                ])
                ->add('meta', RangeType::class, [
                    'label' => 'Meta',
                    'required' => false,
                ])
                ->add('etiquetas', TagInputType::class, [
                    'label' => 'Etiquetas'
                ])
                ->add('Enviar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }

}
