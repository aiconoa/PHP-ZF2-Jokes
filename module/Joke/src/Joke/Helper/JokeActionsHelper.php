<?php

namespace Joke\Helper;


use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

/**
 * Class ViewActionsHelper
 * Visit http://framework.zend.com/manual/2.3/en/modules/zend.view.helpers.advanced-usage.html for more informations
 * about custom view helpers
 * @package Joke\view\Helper
 */
class JokeActionsHelper extends AbstractHelper
                        implements ServiceLocatorAwareInterface {

    private $serviceLocator;

    public function __invoke($joke, $actions)
    {
        $user = $this->serviceLocator->getServiceLocator()->get("UserService")->getCurrentUser();
        $jokeAccessService = $this->serviceLocator->getServiceLocator()->get('JokeAccessService');

        $html = "";
        if(isset($actions['edit'])) {
            if($jokeAccessService->canDoJokeAction('edit', $user, $joke)) {
                $urlViewHelper = $this->getView()->plugin('url');
                $html .= '<a class="btn btn-default" href="'.$urlViewHelper('jokes/edit', array("id"=> $joke->getId())).'" role="button">'
                        . $actions['edit']
                        .'</a>';
            }
        }

        if(isset($actions['delete'])) {
            if($jokeAccessService->canDoJokeAction('delete', $user, $joke)) {
                $urlViewHelper = $this->getView()->plugin('url');
                $html .= '<a class="btn btn-danger" href="'.$urlViewHelper('jokes/delete', array("id"=> $joke->getId())).'" role="button">'
                    . $actions['delete']
                    .'</a>';
            }
        }

        // get current logged user

        return $html;
    }

    protected function editAction() {
        return "edit";
    }


    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }


}