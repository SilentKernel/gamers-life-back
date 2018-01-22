<?php

namespace QuoteCMS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType {

    protected function buildUserForm(FormBuilderInterface $builder, array $options) {
        parent::buildUserForm($builder, $options);
        $builder->remove('username');
    }

    public function getName()
    {
        return 'quotecms_user_edit_profile';
    }
}