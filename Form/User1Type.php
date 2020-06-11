<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add ('companyName',TextType::class ,['label'=>'Société',
                 'attr'=>['class' => ' form-control col-md-6 mb-3 ']
            ])
            ->add ('responsableName',TextType::class ,['label'=>'Nom de Responsable',  'attr'=>['class' => ' form-control col-md-6 mb-3 '],])
            ->add('email',EmailType::class,[
                'constraints' => [new NotBlank
                (['message' => 'Merci de saissir votre email'
            ])
            ],
                'required' => true ,
                'attr'=>['class' => ' form-control col-md-6 mb-3 '],
              ] ) 
           

        ->add ('valider', SubmitType::class,['attr'=>['class' =>'form-control-submit-button',
            "style"=> 'width: 426px'
],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
