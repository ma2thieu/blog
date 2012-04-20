<?php

namespace wbx\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
            ->add('title')
            ->add('text')
            ->add('author')
        ;
    }


    public function getName() {
        return 'wbx_adminbundle_posttype';
    }
}

