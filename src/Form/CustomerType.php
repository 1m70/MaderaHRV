<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => "Nom",
                'attr' => [
                    'placeholder' => "Entrez un nom"
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => "Prénom",
                'attr' => [
                    'placeholder' => "Entrez un prénom"
                ]
            ])
            ->add('phone', TextType::class,[
                'label' => "Numéro de téléphone",
                'attr' => [
                    'placeholder' => "Entrez un numéro de téléphone"
                ]
            ])
            ->add('email', TextType::class,[
                'label' => "E-mail",
                'attr' => [
                    'placeholder' => "Entrez un email"
                ]
            ])
            ->add('adress', TextType::class,[
                'label' => "Adresse",
                'attr' => [
                    'placeholder' => "Entrez une adresse"
                ]
            ])
            ->add('city', TextType::class,[
                'label' => "Ville",
                'attr' => [
                    'placeholder' => "Entrez une ville"
                ]
            ])
            ->add('postalCode', TextType::class,[
                'label' => "Code postal",
                'attr' => [
                    'placeholder' => "Entrez un code postal"
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
