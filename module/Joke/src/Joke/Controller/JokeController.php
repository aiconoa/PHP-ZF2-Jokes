<?php

namespace Joke\Controller;

use Joke\Entity\Joke;
use Joke\Form\JokeForm;
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

    protected function findJokeFromRouteParam()
    {
        $id = $this->params()->fromRoute("id");
        return $id == null ? null : $this->getServiceLocator()->get("JokeService")->findJoke($id);
    }

    public function showAction()
    {
        $joke = $this->findJokeFromRouteParam();
        if($joke == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $vm = new ViewModel();
        $vm->setVariable("joke", $joke);
        return $vm;
    }

    public function addAction()
    {
        $form = new JokeForm();
        $joke = new Joke();
        $form->setHydrator(new ClassMethods());
        $form->bind($joke);
        $isPostBack = false;
        if($this->getRequest()->isPost()) {
            $isPostBack = true;
            $form->setData($this->getRequest()->getPost());

            if($form->isValid()) {

                // the validated data can be found here $form->getData();
                // the raw values are available on the $formInputFilter
//                $filter = $form->getInputFilter();
//
//                $rawValues    = $filter->getRawValues();
//                $nameRawValue = $filter->getRawValue('name');
                //echo $joke;
                $this->getServiceLocator()->get("JokeService")->createOrUpdateJoke($joke);
                return $this->redirect()->toRoute('jokes');
            }
        }

        $vm = new ViewModel();
        $vm->setVariable("viewTitle", "Add new joke");
        $vm->setVariable("createOrEditFormUrl", "addJoke");
        $vm->setVariable("form", $form);
        $vm->setVariable("isPostBack", $isPostBack);
        $vm->setTemplate("joke/joke/createOrEdit.phtml");

        return $vm;
    }

    public function editAction()
    {
        $joke = $this->findJokeFromRouteParam();
        if($joke == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new JokeForm();
        $form->setHydrator(new ClassMethods());
        $form->bind($joke);
        $isPostBack = false;
        if($this->getRequest()->isPost()) {
            $isPostBack = true;
            $form->setData($this->getRequest()->getPost());

            if($form->isValid()) {
                $this->getServiceLocator()->get("JokeService")->createOrUpdateJoke($joke);
                return $this->redirect()->toRoute('jokes');
            }

        }

        $vm = new ViewModel();
        $vm->setVariable("viewTitle", "Edit joke");
        $vm->setVariable("createOrEditFormUrl", "jokes/edit");
        $vm->setVariable("form", $form);
        $vm->setVariable("isPostBack", $isPostBack);
        $vm->setTemplate("joke/joke/createOrEdit.phtml");

        return $vm;
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute("id");
        if($id == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->getServiceLocator()->get("JokeService")->deleteJoke($id);
        return $this->redirect()->toRoute('jokes');
    }
}