<?php
namespace Joke\Form;

use Zend\Form\Form;

// http://framework.zend.com/manual/2.3/en/modules/zend.form.intro.html
class JokeForm extends Form {
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct('jokeForm');

        $this->setInputFilter(new JokeInputFilter());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
                'label' => 'title',
            ),

        ));
        $this->add(array(
            'name' => 'text',
            'type' => 'Textarea',
            'attributes' => array(
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'text',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
} 