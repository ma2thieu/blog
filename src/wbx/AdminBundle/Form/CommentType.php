<?php

namespace wbx\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CommentType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
            ->add('text')
        ;
    }


    public function getName() {
        return 'wbx_adminbundle_commenttype';
    }

    public function getDefaultOptions() {
        return array(
            'data_class' => 'wbx\CoreBundle\Entity\Comment',
        );
    }

}

