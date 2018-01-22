<?php

namespace QuoteCMS\PostBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;


class PostModeratorType extends PostType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('validated',null, array('required' => false))
            ->add('title',null, array('required' => true))
            ->remove('formUId')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return parent::getName() . "_moderate";
    }
}