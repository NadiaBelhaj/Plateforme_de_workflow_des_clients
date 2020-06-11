<?php

namespace App\Form;
use App\Entity\Contact;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
                ->add('sujet',TextType::class,['attr'=>['class' =>'form-control col-md-6 mb-3  form-control'],'label'=> 'Objet', 'required' => true ,
            'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir vote nom',
                    ])],])
                  ->add('message',CKEditorType::class,['attr'=>['class' =>'form-control col-md-6 mb-3  form-control'],'required' => true ,
            'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir vote nom',
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
