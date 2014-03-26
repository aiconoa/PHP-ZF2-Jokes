<?php

namespace Joke\Controller;

use Zend\Mvc\Controller\AbstractActionController;
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
} 