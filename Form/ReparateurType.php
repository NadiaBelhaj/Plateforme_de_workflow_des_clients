<?php

namespace App\Form;

use App\Entity\Reparateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class ReparateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', TextType::class, ['attr' => ['class' => ' form-control col-md-6 mb-3 '],
                'label' => 'Nom',
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  le Nom'
                ])
                ],])
            ->add('prenom', TextType::class, ['attr' => ['class' => ' form-control col-md-6 mb-3 '],
                'label' => 'Prenom ',
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  le Nom'
                ])
                ],])
            ->add('email', Emailtype::class, ['attr' => ['class' => ' form-control col-md-6 mb-3 '],
                'label' => 'Email ', 'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  l"email'
                ])
                ],])
            ->add('Telephone', TextType::class, ['attr' => ['class' => ' form-control col-md-6 mb-3 '],
                'label' => 'Telephone ', 'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  le Telephone'
                ])
                ],])
            ->add('adresse', TextType::class, ['attr' => ['class' => ' form-control col-md-6 mb-3 '],
                'label' => 'Adresse ', 'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  l"adresse'
                ])
                ],])
            ->add('specialite', ChoiceType::class, [
                'choices' => ['Ordinateurs' => 'Ordinateurs',
                    'Smartphone' => 'Smartphone',
                    'Tablette' => 'Tablette',
                    'Autre' => 'Autre'],
                'label' => 'Spécialite ',
                'attr' => ['class' => 'form-control col-md-6 mb-3'],
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir la spécialite'
                ])
                ],]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reparateur::class,
        ]);
    }
}
