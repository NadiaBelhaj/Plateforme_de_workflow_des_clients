<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;

class inscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email', 'required' => true ,
                'constraints' => [
                    new NotBlank([
                        'message' => 'l"Email est obligatoire',
                    ])],])
            ->add('roles', choiceType::class, [
                'choices' => [
                    'ResponsableB2B' => 'ROLE_RESPB',
                    'ResponsableTECH' => 'ROLE_RESPT',
                    'client' => 'ROLE_CLIENT',
                    'Admin' => 'ROLE_ADMIN'],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Role',  'required' => true ,
'constraints' => [
                    new NotBlank([
                        'message' => 'le role est obligatoire',
                    ])],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de passe', 'required' => true ,
                'constraints' => [
                    new NotBlank([
                        'message' => 'le Mot de passe est obligatoire',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'la long Votre mot de passe doit depassé{{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('companyName', TextType::class, ['attr' => ['class' => ''],
                'label' => 'Raison social',  'required' => true ,
                'constraints' => [
                    new NotBlank([
                        'message' => 'le Raison sociale est obligatoire',
                    ])],])
            ->add('responsableName', TextType::class, ['attr' => ['class' => ' '],
                'label' => 'Nom ', 'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom complet est obligatoire',
                    ])],])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,  'required' => true ,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}