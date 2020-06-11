<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add ('companyName',TextType::class,[  'attr'=>['class' => ' form-control col-md-6 mb-3 '],
                'label'=> 'Société ','constraints' => [
                    new NotBlank([
                        'message' => 'le raison sociale est obligatoire',
                    ])],])
            ->add ('responsableName',TextType::class,['attr'=> ['class' => 'form-control col-md-6 mb-3'],
                'label'=> 'Nom complet','constraints' => [
                    new NotBlank([
                        'message' => 'Nom complet est obligatoire',
                    ])],])
            ->add('email',EmailType::class,[
                'constraints' => [new NotBlank
                (['message' => 'l"email est obligatoire'
            ])
            ],
                'required' => true ,
                'attr'=> ['class' => 'form-control col-md-6 mb-3']
              ] )
            ->add('roles',choiceType::class,[
                'choices' =>[
                             'ResponsableB2B'=>'ROLE_RESPB',
                              'ResponsableTECH'=>'ROLE_RESPT',
                                   'client'=>'ROLE_CLIENT',
                                   'Admin'=>'ROLE_ADMIN'],
                    'expanded'=> true,
                    'multiple'=> true ,

                    'label'=> 'Roles '
]
    )

        ->add ('Enregistrer', SubmitType::class,['attr'=>['class' =>'btn'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
