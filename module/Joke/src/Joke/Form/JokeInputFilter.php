<?php

namespace Joke\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator;

//http://framework.zend.com/manual/2.3/en/modules/zend.input-filter.intro.html
class JokeInputFilter extends InputFilter {

    function __construct()
    {
//      http://framework.zend.com/manual/2.3/en/modules/zend.validator.html
//      http://framework.zend.com/manual/2.3/en/modules/zend.filter.html#zend-filter-introduction
        $this->add(array(
            'name' => 'title',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 5
                    ),
                ),
            ),
            'filters' => array(
                array(
                    'name' => 'string_trim'
                )
            )
        ));

        $this->add(array(
            'name' => 'text',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'not_empty',
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 5
                    ),
                ),
            ),
            'filters' => array(
                array(
                    'name' => 'string_trim'
                )
            )
        ));
    }
}