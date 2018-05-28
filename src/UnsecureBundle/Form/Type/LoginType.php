<?php

namespace UnsecureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', 'text', array(
            'label' => 'Войти',
        ));
        $builder->add('pwd', 'password', array(
            'label' => 'пароль',
        ));
        $builder->add('connect', 'submit', array(
            'label' => 'войдите',
            'attr' => array(
                'class' => 'btn btn-success',
            ),
        ));
    }

    public function getName()
    {
        return 'unsecureBundle_logintype';
    }

}
