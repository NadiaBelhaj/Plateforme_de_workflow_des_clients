<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('societe',TextType::class ,[
                'attr'=>['class' => 'form-control-input form-group col-lg-6 '],'label'=>'Raison Sociale','required'=> false])
             ->add('NOM',TextType::class,[  'attr'=>['class' => 'form-control-input form-group col-lg-6  '],'label'=>'Nom et prénom',])
            ->add('Email',EmailType::class ,[  'attr'=>['class' => 'form-control-input form-group col-lg-6 '],'label'=>'Email',])
            ->add('numerot',TextType::class,[  'attr'=>['class' => 'form-control-input form-group col-lg-6 '],'label'=>'Numero Telephone',])
            ->add('dateD',DateType::class,['attr'=>['class'=>"input-append date dpYears  input-group-btn   fa fa-calendar"],'label'=>'date Debut',])
            ->add('datef',DateType::class ,['attr'=>['class'=>"input-append date dpYears input-group-btn   fa fa-calendar"],'label'=>'Date fin'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
