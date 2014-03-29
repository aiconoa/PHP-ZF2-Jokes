<?php

namespace User\Service;

use Joke\Entity\Joke;
use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;
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
     * @param User $user
     * @param Joke $joke
     * @return bool
     */
    public function canEditJoke($user, $joke) {
        if($user == null) {
            return false;
        }

        return $this->rbac->isGranted($user->getRole, 'joke:all')
           ||  $this->rbac->isGranted($user->getRole, 'joke:edit[ifAuthor]', new UserIsJokeAuthorAssertion($user, $joke));
    }

    public function canDeleteJoke($user, $joke) {
        if($user == null) {
            return false;
        }

        return $this->rbac->isGranted($user->getRole, 'joke:all')
        ||  $this->rbac->isGranted($user->getRole, 'joke:delete[ifAuthor]', new UserIsJokeAuthorAssertion($user, $joke));
    }

    /**
     * @param User $user
     * @param Joke $joke
     * @return bool
     */
    public function canAddJoke($user, $joke) {
        return $user != null;
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


class UserIsJokeAuthorAssertion implements AssertionInterface {

    private $joke;
    private $user;

    function __construct($user, $joke)
    {
        $this->user = $user;
        $this->joke = $joke;
    }

    /**
     * Assertion method - must return a boolean.
     *
     * @param  Rbac $rbac
     * @return bool
     */
    public function assert(Rbac $rbac)
    {
        return $this->joke->getAuthor() == $this->user;
    }
}