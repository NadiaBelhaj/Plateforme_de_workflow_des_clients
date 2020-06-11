<?php

namespace App\Form;

use App\Entity\Prospect;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class ProspectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',ChoiceType::class,[
                    'choices' =>['Startup'=>'Startup',
                     'PME'=>'PME',
                     'Grand Entreprise'=>'Grand Entreprise',],
                'attr'=>['class' => ' form-control col-md-6 mb-3 '],
                'label'=> 'Type ',
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  le type'
                ])]
            ],)
            ->add('pourcentage_avan',TextType::class,[  'attr'=>['class' => ' form-control col-md-6 mb-3 '],
                'label'=> 'Pourcentage d"avancement',
             'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  le pourcentage d"avantage'
                ])]
            ])
            
            ->add('contact_name',TextType::class,[  'attr'=>['class' => " form-control col-md-6 mb-3 "],
                'label'=> 'Nom et prénom ', 'constraints' => [new NotBlank
                (['message' => 'Merci de saisir le nom et le prenom'
                ])]
            ])
            ->add('company',TextType::class,[  'attr'=>['class' => ' form-control col-md-6 mb-3 '],
                'label'=> 'Raison sociale ',
                 'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  le Raison sociale'
                ])]
            ])
            ->add('contact_position',TextType::class,[  'attr'=>['class' => ' form-control col-md-6 mb-3 '],
                'label'=> 'Grade du Responsable',
                 'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  le Grade de Responsable'
                ])]
            ])
            ->add('mail',EmailType::class ,[  'attr'=>['class' => ' form-control col-md-6 mb-3 '],
                'label'=> 'Email ', 
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  l"Email'
                ])]
            ])
            ->add('phone',TextType::class,[  'attr'=>['class' => ' form-control col-md-6 mb-3 '],
                'label'=> 'télephone ',
                 'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  le Telephone'
                ])]
            ])
           
            ->add ('adresse',TextType::class,[  'attr'=>['class' => ' form-control col-md-6 mb-3 '],
                'label'=> 'Adresse ',
             'constraints' => [new NotBlank
                (['message' => 'Merci de saisir  l"adresse'
                ])]])
         
                
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,
        ]);
    }
}
