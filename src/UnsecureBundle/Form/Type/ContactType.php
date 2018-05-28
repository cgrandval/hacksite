<?php

namespace UnsecureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array(
            'label' => 'электронная почта',
        ));
        $builder->add('message', 'textarea', array(
            'label' => 'сообщение',
            'attr' => array(
                'placeholder' => 'ваше сообщение',
            ),
        ));
        $builder->add('submit', 'submit', array(
            'label' => 'послать',
            'attr' => array(
                'class' => 'btn btn-success',
            ),
        ));
    }

    public function getName()
    {
        return 'unsecureBundle_contacttype';
    }

}
