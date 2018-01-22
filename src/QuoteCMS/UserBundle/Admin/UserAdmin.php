<?php

namespace QuoteCMS\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('roles')
            ->add('id')
            ->add('nickname')
            ->add('inscriptionDate')
            ->add('facebookId')
            ->add('googleId')
            ->add('twitterId')
            ->add('OAuth')
            ->add('OAuthProfilePicture')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('roles')
            ->add('id')
            ->add('nickname')
            ->add('inscriptionDate')
            ->add('facebookId')
            ->add('googleId')
            ->add('twitterId')
            ->add('OAuth')
            ->add('OAuthProfilePicture')
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
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('password')
            ->add('lastLogin')
            ->add('locked')
            ->add('expired')
            ->add('roles')
            ->add('id')
            ->add('nickname')
            ->add('inscriptionDate')
            ->add('facebookId')
            ->add('googleId')
            ->add('twitterId')
            ->add('OAuth')
            ->add('OAuthProfilePicture')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('locked')
            ->add('expired')
            ->add('roles')
            ->add('id')
            ->add('nickname')
            ->add('inscriptionDate')
            ->add('facebookId')
            ->add('googleId')
            ->add('twitterId')
            ->add('OAuth')
            ->add('OAuthProfilePicture')
        ;
    }
}
