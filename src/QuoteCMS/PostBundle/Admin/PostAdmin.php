<?php

namespace QuoteCMS\PostBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('creationDate')
            ->add('story')
            ->add('videoUrl')
            ->add('validated')
            ->add('game')
            ->add('pictures')
            ->add('ip')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('creationDate')
            ->add('story')
            ->add('videoUrl')
            ->add('validated')
            ->add('game')
            ->add('pictures')
            ->add('ip')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('creationDate')
            ->add('story')
            ->add('videoUrl')
            ->add('validated')
            ->add('game')
            ->add('pictures')
            ->add('ip')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('slug')
            ->add('creationDate')
            ->add('story')
            ->add('videoUrl')
            ->add('validated')
            ->add('game')
            ->add('pictures')
            ->add('ip')
        ;
    }
}
