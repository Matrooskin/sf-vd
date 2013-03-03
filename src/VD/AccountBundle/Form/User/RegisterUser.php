<?php

namespace VD\AccountBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterUser extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array('label' => 'Elektroninio pašto adresas'));
        $builder->add('password', 'repeated', array(
            'type' => 'password',
            'first_options'  => array('label' => 'Slaptažodis'),
            'second_options' => array('label' => 'Pakartoti slaptažodį'),
            'invalid_message' => 'Slaptažodžiai nesutampa'
        ));
//        $builder->add('password2', 'password', array('mapped' => false));
        $builder->add('name', 'text', array('label' => 'Jūsų vardas'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VD\AccountBundle\Entity\User',
        ));
    }

    public function getName()
    {
        return 'registerUser';
    }
}