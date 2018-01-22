<?php

namespace QuoteCMS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserPrefType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anonymousPost', 'checkbox',  array('required' => false))
            ->add('hideEmail', 'checkbox',  array('required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QuoteCMS\UserBundle\Entity\UserPref'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quotecms_userbundle_userpref';
    }
}
