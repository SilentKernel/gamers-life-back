<?php

namespace Silentkernel\CommentBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;


class ReportCommentModeratorType extends CommentType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('reportCount',null, array('required' => false))

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
