<?php

namespace App\Form;


use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
            # Champ nom
            ->add('nom', TextType::class, [
                'required'      => true,
                'label'         => false,
                'attr'          => [
                    'class'         =>  'form-control',
                    'placeholder'   =>  'Nom'
                ]
            ])

			# Champ prenom
			->add('prenom', TextType::class, [
				'required'      => true,
				'label'         => false,
				'attr'          => [
					'class'         =>  'form-control',
					'placeholder'   =>  'Prénom'
				]
			])

            # Champ email
            ->add('mail', EmailType::class, [
                'required'      => true,
                'label'         => false,
                'attr'          => [
                    'class'         =>  'form-control',
                    'placeholder'   =>  'Email'
                ]
            ])

            # Champ telephone
            ->add('telephone', TextType::class, [
                'required'      => true,
                'label'         => false,
                'attr'          => [
                    'class'         =>  'form-control',
                    'placeholder'   =>  'Telephone'
                ]
            ])

			# Champ mot de passe
			->add('message', TextareaType::class, [
				'required'      => true,
				'label'         => false,
				'attr'          => [
					'class'         =>  'form-control',
					'placeholder'   =>  'Message',
                    'rows'         =>   6
				]
			])

			# Bouton INSCRIPTION
			->add('reset', ResetType::class, array(
				'label' => 'Reset',
				'attr' 	=> [
					'class'         =>  'btn btn-lg btn-block bouton_lien col-xs-6',
                    'id'           =>   'contact_reset'
				]))
				
			->add('submit', SubmitType::class, [
				'label' => 'Envoyer',
				'attr'      => [
					'class' => 'btn btn-lg btn-block bouton_lien col-xs-6',
                    'id'           =>   'contact_validate'
				]
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => Contact::class,
		));
	}
}