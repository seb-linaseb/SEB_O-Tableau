<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        //if($message) { 

            // $builder
            // ->add('content', TextType::class,array(
            //         'attr' => array(
            //             'placeholder' => 'Message'
            //         )
            //         )
            // )
            // ->add( 'users', EntityType::class,[
            //     'class'=> User::class,
            //     'expanded' =>true,
            //     'multiple' =>true,
            //     ]
            // );
        //} else {
        
            $builder
                ->add('content', TextType::class,array(
                    'attr' => array(
                        'placeholder' => 'Message'
                    )
                ));
        //};
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
