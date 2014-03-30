<?php

namespace Joke\Service;

use Joke\Entity\Joke;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
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

    /**
     * @param null $offset
     * @param null $limit
     * @param null $order
     * @return ResultSet of $jokes
     */
    public function findAllJokes($offset = null, $limit = null, $order = null)
    {
        $jokeTableGateway = $this->serviceLocator->get('JokeTableGateway');

        // here we are using a closure but
        // $jokeTableGateway->selectWith can also be used, passing a Zend\Db\Sql\Select object
        // for more information about Zend\Db\Sql\Select http://framework.zend.com/manual/2.3/en/modules/zend.db.sql.html
        $resultSet = $jokeTableGateway->select(
            function (Select $select) use ($offset, $limit, $order) {
                if ($offset != null) {
                    $select->offset($offset);
                }
                if ($limit != null) {
                    $select->limit($limit);
                }

                if ($order != null) {
                    $select->order($order);
                }
            }
        );

        return $resultSet;
    }

    public function findJoke($id)
    {
        $jokeTableGateway = $this->serviceLocator->get('JokeTableGateway');
        $resultSet = $jokeTableGateway->select(array('id' => (int) $id));
        $joke = $resultSet->current();

        return $joke;
    }

    public function createOrUpdateJoke(Joke $joke)
    {

        $jokeTableGateway = $this->serviceLocator->get('JokeTableGateway');
        if ($joke->getId() == null) {
            $joke->setPostedOn(date('Y-m-d H:i:s'));
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