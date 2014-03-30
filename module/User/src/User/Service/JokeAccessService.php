<?php

namespace User\Service;

use Joke\Entity\Joke;
use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class JokeAccessService implements ServiceLocatorAwareInterface
{
    private $serviceLocator;

    /**
     * @var Rbac
     */
    private $rbac;

    function __construct()
    {
        $this->rbac = $this->buildDummyRbac();
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

    /**
     * @param string $action
     * @param User $user
     * @param Joke $joke
     * @return bool
     */
    public function canDoJokeAction($action, $user, $joke) {
        if($user == null || $user->getRole() == null) {
            return false;
        }

        if($action == 'add') { // every user can add a joke
            return true;
        }

        $role = $this->rbac->getRole($user->getRole()->getName());

        $assertionIfAuthor = function($rbac) use ($user, $joke) {
            return $user->getId() == $joke->getAuthorId();
        };


        return      $this->rbac->isGranted($role, 'joke:all')
                ||  $this->rbac->isGranted($role, 'joke:'.$action.'[ifAuthor]', $assertionIfAuthor );
    }

    /**
     * Returns a dummy RBac. Should be read from database
     * @return Rbac
     */
    private function buildDummyRbac() {
        $rbac = new Rbac();
        $adminRole  = new Role('admin');
        $adminRole->addPermission('joke:all');
        $rbac->addRole($adminRole);

        $authorRole  = new Role('author');
        $authorRole->addPermission('joke:add');
        $authorRole->addPermission('joke:edit[ifAuthor]');
        $authorRole->addPermission('joke:delete[ifAuthor]');
        $rbac->addRole($authorRole);

        return $rbac;
    }

}