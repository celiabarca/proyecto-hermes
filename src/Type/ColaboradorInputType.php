<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 11/05/18
 * Time: 19:57
 */

namespace App\Type;

use App\Form\DataTransformer\ColaboradorArrayToStringTransformer;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ColaboradorInputType extends AbstractType {

    private $colaboradores;

    public function __construct(UserRepository $colaboradores) {
        $this->colaboradores = $colaboradores;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new ColaboradorArrayToStringTransformer($this->colaboradores), true);
    }

    public function buildView(FormView $view, FormInterface $form, array $options) {
        $view->vars['colaboradores'] = $this->colaboradores->findAll();
    }

    public function getParent() {
        return TextType::class;
    }

}