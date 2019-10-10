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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                'required' => false,
                'placeholder' => "Sélectionner la finition"

            ])
            ->add('isolation', EntityType::class, [
                'class' => Isolation::class,
                'choice_label' => 'label',
                'required' => false,
                'placeholder' => "Sélectionner l'isolation"

            ])
            ->add('coverage', EntityType::class, [
                'class' => Coverage::class,
                'choice_label' => 'type',
                'required' => false,
                'label' => 'Couverture',
                'placeholder' => "Sélectionner la couverture"

            ])
            ->add('floor', EntityType::class, [
                'class' => Floor::class,
                'choice_label' => 'type',
                'label' => 'Sol',
                'required' => false,
                'placeholder' => "Sélectionner le sol"

            ])
            ->add('structure', EntityType::class, [
                'class' => Structure::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => "Sélectionner la structure"

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
