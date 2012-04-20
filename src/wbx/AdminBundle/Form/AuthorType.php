<?php

namespace wbx\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AuthorType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
            ->add('firstname')
            ->add('lastname')
        ;
    }


    public function getName() {
        return 'wbx_adminbundle_authortype';
    }
}

