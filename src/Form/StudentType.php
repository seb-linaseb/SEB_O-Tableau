<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Person;
use App\Entity\Student;
use App\Entity\Classroom;
use App\Entity\LunchType;
use App\Form\StudentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Nom'
            )))
            ->add('firstname', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Prénom'
            )))
            ->add('birthdate', BirthdayType::class)  
            ->add('classroom', EntityType::class, [                
                'class' => Classroom::class,                     
                'attr' => array('class' => 'input_label'),
            ])          
            ->add('image_rights', null, [
                'label_attr' => array('class' => 'label_image'),
                'attr' => array('class' => 'input_label'),
            ])       
            ->add('user', EntityType::class, [                
                'class' => User::class,                     
                'multiple' => true,
                'expanded' => true,
                'attr' => array('class' => 'input_label'),
            ])
            ->add('lunchtype', EntityType::class, [                
                'class' => LunchType::class,                    
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'input_label'),
            ])
            ->add('person', EntityType::class, [                
                'class' => Person::class,                    
                'multiple' => true,
                'expanded' => true,
                'attr' => array('class' => 'input_label'),
            ])
            ->add('mondayLunch', null, [
                'label_attr' => array('class' => 'label_lunch'),
                'attr' => array('class' => 'input_label'),
            ])
            ->add('tuesdayLunch', null, [
                'label_attr' => array('class' => 'label_lunch'),
                'attr' => array('class' => 'input_label'),
            ])
            ->add('wednesdayLunch', null, [
                'label_attr' => array('class' => 'label_lunch'),
                'attr' => array('class' => 'input_label'),
            ])
            ->add('thursdayLunch', null, [
                'label_attr' => array('class' => 'label_lunch'),
                'attr' => array('class' => 'input_label'),
            ])
            ->add('fridayLunch', null, [
                'label_attr' => array('class' => 'label_lunch'),
                'attr' => array('class' => 'input_label'),
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }
    
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
