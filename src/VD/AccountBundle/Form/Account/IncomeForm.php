<?php

namespace VD\AccountBundle\Form\Account;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IncomeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('amount', 'money', array('label' => 'Suma', 'currency' => 'LTU'));
        $builder->add(
            'date',
            'date',
            array('label' => 'Data', 'input' => 'datetime', 'widget' => 'choice', 'user_timezone' => 'Europe/Vilnius')
        );
        $builder->add('type', 'text', array('label' => 'Už ką (rūšis)'));
        $builder->add(
            'person',
            'entity',
            array('label' => 'Kas (asmuo)', 'class' => 'VDAccountBundle:User', 'property' => 'name')
        );
        $builder->add('currency', 'choice', array('label' => 'Valiuta', 'choices' => array('LTU')));
        $builder->add('comment', 'textarea', array('label' => 'Pastaba'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'VD\AccountBundle\Entity\Income',
            )
        );
    }

    public function getName()
    {
        return 'income';
    }
}