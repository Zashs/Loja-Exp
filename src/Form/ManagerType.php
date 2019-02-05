<?php

namespace App\Form;

use App\Entity\Manager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ManagerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
              $builder
            ->add('email', EmailType::class,
            array(
                'label'=>'email',
                'required' => true,
                'attr' => ['class' => 'w3-input w3-padding-16 EMAIL','placeholder'=>'email',]
            ))
            ->add('username', TextType::class, array(
                'label'=>'username',
                'required' => true,
                'attr' => ['class' => 'w3-input w3-padding-16 NAME','placeholder'=>'username','autofocus'=>'autofocus']
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password *', 'attr' => ['class' => 'w3-input w3-padding-16','placeholder'=>'Password *']),
                'second_options' => array('label' => 'Repetir Password *', 'attr' => ['class' => 'w3-input w3-padding-16','placeholder'=>'Repetir Password *'])
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Manager::class,
        ));
    }
}