<?php

namespace User\Controller;

use User\Form\UserLoginForm;
use Zend\Debug\Debug;
use Zend\Log\Logger;
use Zend\Mvc\Controller\AbstractActionController;

class UserController extends AbstractActionController {

    public function loginAction() {

        $form = new UserLoginForm();
        if($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if($form->isValid()) {
                $user = $this->getServiceLocator()->get('UserService')->login(
                    $form->getInputFilter()->getValue('username'),
                    $form->getInputFilter()->getValue('password')
                );

                //TODO if user == null => pas authenticated
                // else it's ok !
            }
        }

        return array("form" => $form, "result" => isset($user) ? Debug::dump($user, null, false): "user is not set" );
    }
}