<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Message;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $receiverList = $options['receiverList'];

        

        $url = ($_SERVER["REQUEST_URI"]); 

    if ($url == '/conversation/new') { 

        $builder
        ->add( 'users', EntityType::class,[
            'class'=> User::class,
            'choices'=> $receiverList,
            'expanded' =>true,
            'multiple' =>true,
            ]
        )
        ->add('content', TextareaType::class ,array(
                'attr' => array(
                    'placeholder' => 'Message..'
                )
            )
        )
       ;
    } else {
    
        $builder
            ->add('content', TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Message..'
                )
            ));
    };
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'receiverList' => null,
        ]);
    }
}
