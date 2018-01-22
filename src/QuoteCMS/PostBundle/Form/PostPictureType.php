<?php

namespace QuoteCMS\PostBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostPictureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QuoteCMS\PostBundle\Entity\PostPicture',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention'       => 'post_picture',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quotecms_postbundle_postpicture';
    }
}
