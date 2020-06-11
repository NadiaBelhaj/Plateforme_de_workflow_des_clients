<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company',TextType::class,[

                'constraints' => [new NotBlank
                (['message' => 'Merci de saissir  company'
                ])
                ],
                'label'=> 'Raison sociale',
                'required' => true ,
                'attr'=> ['class' => 'form-control col-md-6 mb-3 ']
            ] )
            ->add('contact_name',TextType::class,[
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir le nom de responsable'
                ])
                ],
                'label'=> 'Nom et prénom',
                'required' => true ,
                'attr'=> ['class' => 'form-control col-md-6 mb-3 ']
            ] )
            ->add('contact_position',TextType::class,[
                'constraints' => [new NotBlank
                (['message' => 'Merci de saissir votre position'
                ])
                ],
                'label'=> 'Grade du responsable',
                'required' => true ,
                'attr'=> ['class' => 'form-control col-md-6 mb-3 ']
            ] )
            ->add('mail',EmailType::class,[
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir la postion email '
                ])
                ],
                 'label'=> 'Email',
                'required' => true ,
                'attr'=> ['class' => 'form-control col-md-6 mb-3']
            ] )
             ->add('phone',TextType::class,[
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir la postion email '
                ])
                ],
                'label'=> 'Telephone',
                'required' => true ,
                'attr'=> ['class' => 'form-control col-md-6 mb-3 ']
            ] )
              ->add('type',TextType::class,[
                'constraints' => [new NotBlank
                (['message' => 'Merci de saisir la postion email '
                ])
                ],
                'label'=> 'Type',
                'required' => true ,
                'attr'=> ['class' => 'form-control col-md-6 mb-3 ']
            ] )
            ->add('adresse',TextType::class,[
                'constraints' => [new NotBlank
                (['message' => 'Merci de saissir adresse'
                ])
                ],
                'label'=> 'Adresse',
                'required' => true ,
                'attr'=> ['class' => 'form-control col-md-6 mb-3 ']
            ] )
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
