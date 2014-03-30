<?php

namespace JokeRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Class JokeRestfulController
 * Form more information about AbstractRestfulController, see http://www.framework.zend.com/manual/2.3/en/modules/zend.mvc.controllers.html#the-abstractrestfulcontroller
 * @package JokeRest\Controller
 */
class JokeRestfulController extends AbstractRestfulController {

    public function getList() {
        // get the query string params
        $limit = (int) $this->params()->fromQuery("limit");
        $offset = (int) $this->params()->fromQuery("offset");
        $order = $this->params()->fromQuery("order"); // ex: title ASC

        // make the query
        $jokes = $this->getServiceLocator()->get("Joke\Service\JokeService")->findAllJokes($offset, $limit, $order);
        $arr = array();
        foreach($jokes as $joke) {
            $arr []= $joke->getArrayCopy();
        }
        // return the result set
        return new JsonModel($arr);
    }

    public function get($id) {
        $id = $this->params()->fromRoute("id");
        $joke = ($id == null ? null : $this->getServiceLocator()->get("JokeService")->findJoke($id));

        if($joke == null) {
            $this->getResponse()->setStatusCode(404);
            return new JsonModel(array("error" => array("code" => "404", "message" => "joke not found")));
        }

        return new JsonModel($joke->getArrayCopy());
    }

    public function create($data)
    {
        $this->methodNotAllowed();
    }

    public function update($id, $data)
    {
        $this->methodNotAllowed();
    }

    public function delete($id)
    {
        $this->methodNotAllowed();
    }

    protected function methodNotAllowed()
    {
        $this->response->setStatusCode(
            \Zend\Http\PhpEnvironment\Response::STATUS_CODE_405
        );
    }

}