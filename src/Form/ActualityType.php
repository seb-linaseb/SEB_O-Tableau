<?php

namespace App\Form;

use App\Entity\Actuality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ActualityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'empty_data' => '', 
                'attr' => array(
                    'placeholder' => 'Titre'
                ),
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min'        => 3,
                        'max'        => 50,
                        'minMessage' => 'Pas assez de caractères (min attendu : {{ limit }})',
                        'maxMessage' => 'Trop caractères (max attendu : {{ limit }})',
                    ])
                ]
            ]) 
            ->add('content', TextareaType::class ,array(
                'attr' => array(
                    'placeholder' => 'Contenu'
                ),
                'empty_data' => '', 
                'constraints' => [
                    new NotBlank(),
                ],
              )
            )   
            ->add('picture_url', FileType::class, [
                'label' => 'Veuillez selectionner votre document sous le format PDF',
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '5000k',                        
                        'mimeTypesMessage' => 'Merci d\'uploader un document valide sous le format PDF',
                    ])
                ],
            ])              
            ->add('Ajouter', SubmitType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actuality::class,
        ]);
    }
}
