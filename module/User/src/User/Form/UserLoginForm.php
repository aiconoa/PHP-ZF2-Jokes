<?php
namespace User\Form;

use Zend\Form\Form;

// http://framework.zend.com/manual/2.3/en/modules/zend.form.intro.html
class UserLoginForm extends Form {
    public function __construct()
    {
        // we want to ignore the name passed
        parent::__construct('userLoginForm');

        $this->setInputFilter(new UserLoginInputFilter());

        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => 'username',
            ),

        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'attributes' => array(
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'password',
                'label_attributes' => array(
                    'class' => 'col-sm-2 control-label',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        ));
    }
} 