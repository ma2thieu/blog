<?php

namespace wbx\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use wbx\FileBundle\Form\FileType as wbxFileType;

class FileType extends wbxFileType {

    public function getName() {
        return 'wbx_adminbundle_filetype';
    }

    public function getDefaultOptions() {
        return array(
            'data_class' => 'wbx\CoreBundle\Entity\File',
        );
    }
}
