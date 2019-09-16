<?php

namespace App\Form;

use App\Entity\PresenceLunch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class PresenceLunchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('is_present', CheckboxType::class, [
                // 'value' => false,
            ])
            //->add('is_ordered')
            //->add('is_canceled')
            ->add('has_eated', CheckboxType::class, [
                'value' => false,
            ])
            //->add('calendar')
            ->add('student')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PresenceLunch::class,
        ]);
    }
}
