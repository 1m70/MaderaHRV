<?php

namespace App\Form;

use App\Entity\Gamme;
use App\Entity\Plan;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Plan1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => "Nom du plan"
            ])
            ->add('gamme', EntityType::class, [
                    'class' => Gamme::class,
                    'choice_label' => 'label',
                    'required' => false,
                    'placeholder' => "Sélectionner la gamme"


            ])
            ->add('modules',CollectionType::class, array(
                'entry_type' => ModuleType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Plan::class,
        ]);
    }
}
