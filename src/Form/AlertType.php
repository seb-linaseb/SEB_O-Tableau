<?php

namespace App\Form;

use App\Entity\Alert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AlertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, array(
            'label' => 'Titre de l\'alerte',
            'attr' => array(
                'placeholder' => 'Titre de l\'alerte'            
            )))        
        ->add('content', TextType::class, array(
            'label' => 'Contenu de l\'alerte',
            'attr' => array(
                'placeholder' => 'Contenu de l\'alerte'            
            )))                    
        ->add('Ajouter', SubmitType::class)
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Alert::class,
        ]);
    }
}
