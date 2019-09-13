<?php

namespace App\Form;

use App\Entity\Actuality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ActualityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
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
            ->add('content')            
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
