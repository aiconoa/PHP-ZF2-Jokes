<?php

namespace User\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator;

//http://framework.zend.com/manual/2.3/en/modules/zend.input-filter.intro.html
class UserLoginInputFilter extends InputFilter {

    function __construct()
    {
//      http://framework.zend.com/manual/2.3/en/modules/zend.validator.html
//      http://framework.zend.com/manual/2.3/en/modules/zend.filter.html#zend-filter-introduction
        $this->add(array(
            'name' => 'username',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
            ),
            'filters' => array(
                array(
                    'name' => 'string_trim'
                )
            )
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
            ),
            'filters' => array(
                //TODO @email
//                array(
//                    'name' => 'string_trim'
//                )
            )
        ));
    }
}