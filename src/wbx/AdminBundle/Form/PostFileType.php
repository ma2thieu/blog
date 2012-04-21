<?php

namespace wbx\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostFileType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
            ->add('file', new FileType(), array(
                'cascade_validation'    => true,
            ))
        ;
    }

    public function getName() {
        return 'wbx_adminbundle_postfiletype';
    }

    public function getDefaultOptions() {
        return array(
            'data_class' => 'wbx\CoreBundle\Entity\PostFile',
        );
    }


}
