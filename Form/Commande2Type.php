<?php

namespace App\Form;

use App\Entity\Commande;

use App\Entity\Category;
use App\Entity\CategoryMarque;
use App\Entity\Categorytypedepanne;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Commande2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         ->add('Societe',TextType::class,[  'attr'=>['class' => 'form-group '],'label'=>' Societe',]
        )
            ->add('NOM',TextType::class,[  'attr'=>['class' => 'form-group '],'label'=>'Nom et prénom',])
           
            ->add('email',EmailType::class,[  'attr'=>['class' => 'form-group'],'label'=>' Email',])
            ->add('numeroT',TextType::class,[  'attr'=>['class' => 'form-group '],'label'=>' Numero Telephone',])
             ->add('appareil',ChoiceType::class,[
                    'choices' =>['Ordinateurs'=>'Ordinateurs',
                     'smartphone'=>'smartphone',
                     'tablette'=>'tablette',
                  'autre'=>'autre'],
               'label'=> 'appariels ',
               'attr'=> ['class' => 'form-group']
           ] )
             ->add('marque',ChoiceType::class,[
                    'choices' =>['HP'=>'HP',
                     'lenovo'=>'lenove',
                     'samsung'=>'samsung',
                  'autre'=>'autre'],
               'label'=> 'Marque ',
               'attr'=> ['class' => 'form-group']
           ] )
           

 ->add('nombre',TextType::class,[  'attr'=>['class' => 'form-group'],'label'=>' Nombre des appariels en panne',])


            ->add('adresse',TextType::class,[  'attr'=>['class' => 'form-group '],'label'=>' Adresse',])
            ->add('livraison',ChoiceType::class,[
                'choices' =>['livreur'=>'livreur',
                              'tout seul'=>'tout seul',

                ],
                'attr'=>['class' => 'form-group'],
                'expanded'=> true,
                'multiple'=> False ,
                'label'=> 'Livraison '])
            
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
