<?php

namespace App\Form;

use App\Entity\CommentInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
class PayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, [
            'label' => 'Phone Number',
          ])
      ->add('country', CountryType::class, [
        'preferred_choices' => ['ES'],
      ])
      ->add('Pagar', SubmitType::class, [
        'label' => 'Continue'
      ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommentInterface::class,
        ]);
    }
}
