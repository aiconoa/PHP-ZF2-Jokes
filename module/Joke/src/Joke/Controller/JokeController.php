<?php

namespace Joke\Controller;

use Joke\Entity\Joke;
use Joke\Form\JokeForm;
use Joke\Form\JokeInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;

class JokeController extends AbstractActionController
{
    public function listAction()
    {
        $jokes = $this->getServiceLocator()->get("Joke\Service\JokeService")->findAllJokes();
        return array("jokes" => $jokes);
    }

    public function showAction()
    {
        $id = $this->params()->fromRoute("id");
        if($id == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $joke = $this->getServiceLocator()->get("JokeService")->findJoke(intval($id));

        if($joke == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $vm = new ViewModel();
        $vm->setVariable("joke", $joke);
        return $vm;
    }

    public function addAction() {
        $form = new JokeForm();
        $joke = new Joke();
        $form->setHydrator(new ClassMethods());
        $form->bind($joke);
        $request = $this->getRequest();
        $isPostBack = false;
        if($request->isPost()) {
            $isPostBack = true;
            $form->setData($request->getPost());

            if($form->isValid()) {

                // the validated data can be found here $form->getData();
                // the raw values are available on the $formInputFilter
//                $filter = $form->getInputFilter();
//
//                $rawValues    = $filter->getRawValues();
//                $nameRawValue = $filter->getRawValue('name');
                //echo $joke;
                $this->getServiceLocator()->get("JokeService")->createJoke($joke);
                return $this->redirect()->toRoute('jokes');
            }

        }

        return array(
            'isPostBack' => $isPostBack,
            'form' => $form);
    }
} 