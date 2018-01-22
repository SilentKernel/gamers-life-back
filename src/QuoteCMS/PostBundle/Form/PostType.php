<?php

namespace QuoteCMS\PostBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('game', 'entity', array(
            'class' => 'QuoteCMSGameBundle:Game',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('g')
                    ->orderBy('g.name', 'ASC');
            },
        ))
            ->add('tempGameName',null, array('required' => false))
            ->add('story',null, array('required' => true))
            ->add('videoUrl', null, array('required' => false))
            ->add('formUId', 'hidden')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QuoteCMS\PostBundle\Entity\Post',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention'       => 'post',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quotecms_postbundle_post';
    }
}
