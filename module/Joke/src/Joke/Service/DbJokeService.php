<?php

namespace Joke\Service;


use Joke\Entity\Joke;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbJokeService implements JokeService , ServiceLocatorAwareInterface {

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

    public function findAllJokes()
    {
        $jokeTableGateway = $this->serviceLocator->get('JokeTableGateway');
        $resultSet = $jokeTableGateway->select();
        return $resultSet;
    }

    public function findJoke($id)
    {
        $jokeTableGateway = $this->serviceLocator->get('JokeTableGateway');
        $rowset = $jokeTableGateway->select(array('id' => (int) $id));
        $row = $rowset->current();
        return $row;
    }

    public function createOrUpdateJoke(Joke $joke)
    {

        $jokeTableGateway = $this->serviceLocator->get('JokeTableGateway');
        if ($joke->getId() == 0) {
            $jokeTableGateway->insert($joke->getArrayCopy());
        } else {
            if ($this->findJoke($joke->getId())) {
                $jokeTableGateway->update($joke->getArrayCopy(), array('id' => $joke->getId()));
            } else {
                throw new \Exception('Can not update Joke: id does not exist');
            }
        }
    }

    /**
     * @param int $id
     */
    public function deleteJoke($id)
    {
        $jokeTableGateway = $this->serviceLocator->get('JokeTableGateway');
        $jokeTableGateway->delete(array('id' => (int) $id));
    }

} 