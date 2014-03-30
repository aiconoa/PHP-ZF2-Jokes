<?php

namespace User\Service;

use User\Entity\User;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Read http://framework.zend.com/manual/2.3/en/modules/zend.authentication.intro.html for more information about Zend\Authentication
 * Class UserService
 * @package User\Service
 */
class UserService implements ServiceLocatorAwareInterface {

    private $dbAdapter;

    function __construct($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    private $serviceLocator;
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
     * Authenticate the user, put its username in the current session (starts a new one if required) and returns a
     * User object.
     * @param $username
     * @param $password
     * @return User the logged user or null if cannot log the user
     */
    public function login($username, $password) {
        $authService = $this->getServiceLocator()->get('AuthenticationService');
        $authService->getAdapter()
            ->setIdentity($username)
            ->setCredential($password);
        //    ->setCredentialTreatment('MD5(?)');

        // because we're using an authentication service,
        // in case of a successful authentication the identity will be stored inside the session
        $result = $authService->authenticate();

        if(! $result->isValid()) {
            // here we can change the behaviour and throw an exception instead
            return null;
        }

        //$username = $result->getIdentity();
        return $this->findUserByUsername($username);
    }

    public function logout() {
        $authService = $this->getServiceLocator()->get('AuthenticationService');
        $authService->clearIdentity();
    }

    /**
     * @return the currently authenticated user if any. Returns null if no user is currently authenticated
     */
    public function getCurrentUser() {
        $authService = $this->getServiceLocator()->get('AuthenticationService');
        return $this->findUserByUsername($authService->getIdentity());
    }

    /**
     * Finds the user in the datastore by its username.
     * @param $username
     * @return User or null if $username does not match any user.
     */
    public function findUserByUsername($username)
    {
        $userTableGateway = $this->serviceLocator->get('UserTableGateway');
        $resultSet = $userTableGateway->select(array('username' => $username));

        $user = $resultSet->current();

        if($user == null) {
            return null;
        }

        $roleTableGateway = $this->serviceLocator->get('RoleTableGateway');
        $resultSet = $roleTableGateway->select(array('user_id' => $user->getId()));
        $role = $resultSet->current();
        if($role) {
            $user->setRole($role);
        }

        return $user;
    }

} 