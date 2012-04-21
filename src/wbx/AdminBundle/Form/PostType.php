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
            ->add('files', 'collection', array(
                'type' => new PostFileType(),
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'cascade_validation'    => true,
                'options' => array(
                    'data_class' => 'wbx\CoreBundle\Entity\PostFile'
                )
            ))
            ->add('comments', 'collection', array(
                'type' => new CommentType(),
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'cascade_validation'    => true,
                'options' => array(
                    'data_class' => 'wbx\CoreBundle\Entity\Comment'
                )
            ))
        ;
    }


    public function getName() {
        return 'wbx_adminbundle_posttype';
    }
}

