<?php
namespace wbx\AdminBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AuthorFilterType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('firstname', 'filter_text', array(
            "condition_pattern" => "%%%s%%"
        ));
        $builder->add('lastname', 'filter_text', array(
            "condition_pattern" => "%%%s%%"
        ));
    }


    public function getDefaultOptions() {
        return array(
            'csrf_protection' => false
        );
    }


    public function getName() {
        return 'author_filter';
    }

}