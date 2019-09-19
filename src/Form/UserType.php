<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'Email'
            )))
            ->add('username', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Nom d\'utilisateur'
            )))
            ->add('password', PasswordType::class, array(
                'attr' => array(
                    'placeholder' => 'Mot de passe'
            )))
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Nom'
            )))
            ->add('firstname', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Prénom'
            )))
            ->add('address', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Adresse'
            )))
            ->add('postalcode', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Code Postal'
            )))
            ->add('city', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Ville'
            )))
            ->add('phone', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Téléphone'
            )))
            ->add('mobile_phone', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Téléphone portable'
            )))
            ->add('job_phone', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Téléphone du travail'
            )))
            ->add('communication_agreement')
            ->add('image_agreement')
            ->add('role')
            ->add('Ajouter', SubmitType::class)            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
