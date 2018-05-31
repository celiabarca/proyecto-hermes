<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 14/05/18
 * Time: 15:20
 */

namespace App\Type;


use App\Repository\TagRepository;
use App\Form\DataTransformer\TagArrayToStringTransformer;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class TagInputType extends AbstractType {

    private $tags;

    public function __construct(TagRepository $tags) {
        $this->tags = $tags;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TagArrayToStringTransformer($this->tags), true);
    }

    public function buildView(FormView $view, FormInterface $form, array $options) {
        $view->vars['tags'] = $this->tags->findAll();
    }

    public function getParent() {
        return \Symfony\Component\Form\Extension\Core\Type\TextareaType::class;
    }

}