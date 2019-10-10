<?php

namespace App\Form;

use App\Entity\Coverage;
use App\Entity\Finition;
use App\Entity\Floor;
use App\Entity\Isolation;
use App\Entity\Module;
use App\Entity\Structure;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')

            ->add('length')
            ->add('width')
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'label',

            ])
            ->add('finition', EntityType::class, [
                'class' => Finition::class,
                'choice_label' => 'label',

            ])
            ->add('isolation', EntityType::class, [
                'class' => Isolation::class,
                'choice_label' => 'label',

            ])
            ->add('coverage', EntityType::class, [
                'class' => Coverage::class,
                'choice_label' => 'type',

            ])
            ->add('floor', EntityType::class, [
                'class' => Floor::class,
                'choice_label' => 'type',

            ])
            ->add('structure', EntityType::class, [
                'class' => Structure::class,
                'choice_label' => 'name',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
