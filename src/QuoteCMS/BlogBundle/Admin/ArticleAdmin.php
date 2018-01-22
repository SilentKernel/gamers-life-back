<?php

namespace QuoteCMS\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ArticleAdmin extends Admin
{
  private $ct;

  public function __construct($code, $class, $baseControllerName, $ct=null)
  {
    parent::__construct($code, $class, $baseControllerName);
    $this->ct = $ct;
  }

  /**
  * @param DatagridMapper $datagridMapper
  */
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
    ->add('title')
    ->add('content')
    ->add('categories')
    ->add('keywords')
    ->add('user')
    ;
  }

  /**
  * @param ListMapper $listMapper
  */
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
    ->add('title')
    ->add('content')
    ->add('categories')
    ->add('keywords')
    ->add('user')
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
    ->add('title')
    ->add('content')
    ->add('categories')
    ->add('keywords')
    ;
  }

  /**
  * @param ShowMapper $showMapper
  */
  protected function configureShowFields(ShowMapper $showMapper)
  {
    $showMapper
    ->add('title')
    ->add('content')
    ->add('categories')
    ->add('keywords')
    ;
  }

  public function prePersist($article)
  {
    $article->setUser($this->ct->get('security.context')->getToken()->getUser());
  }
}
