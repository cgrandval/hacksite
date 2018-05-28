<?php
namespace UnsecureBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', 'textarea', array(
            'label' => false,
            'attr' => array(
                'rows' => 15
            ),
        ));
        
        $builder->add('private', 'checkbox', array(
            'label' => "проект",
            'required' => false
        ));
        
        $builder->add('submit', 'submit', array(
            'label' => 'Сохранить статью',
            'attr' => array(
                'class' => 'btn btn-success',
            ),
        ));
    }
    public function getName()
    {
        return 'unsecureBundle_subjecttype';
    }
}