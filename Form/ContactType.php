<?php

namespace App\Form;
use App\Entity\Contact;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class , ['attr'=>['class' =>'form-control col-md-6 mb-3  form-control'],
                'label'=> 'Nom',
                 'required' => true ,
            'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir vote nom',
                    ])],])
              ->add('email',EmailType::class,['attr'=>['class' =>'form-control col-md-6 mb-3  form-control'],
                'label'=> 'Email',
                 'required' => true ,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre Email',
                    ])], ])
                ->add('sujet',TextType::class,['attr'=>['class' =>'form-control col-md-6 mb-3  form-control'],
                     'required' => true ,
                    'label'=> 'Objet', 'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre mot de passe ',
                    ])],])
                  ->add('message',CKEditorType::class,['attr'=>['class' =>'form-control col-md-6 mb-3  form-control'],
                    'label'=> 'Message',  'required' => true ,
                    
                    'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre message',
                    ])],])
                    ->add('envoyer',SubmitType::class,['attr'=>['class' =>'form-control-submit-button'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           
            // Configure your form options here
        ]);
    }
}
