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

                if($user != null) {
                    //login successful => go back home ;-)
                    return $this->redirect()->toRoute('home');
                }
            }
        }

        return array("form" => $form);
    }

    public function logoutAction() {
        $this->getServiceLocator()->get('UserService')->logout();
        return $this->redirect()->toRoute('home');
    }
}