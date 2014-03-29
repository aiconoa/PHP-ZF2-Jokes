<?php

namespace User\Factories;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new \Zend\Db\ResultSet\HydratingResultSet(new \Zend\Stdlib\Hydrator\ClassMethods(), new \User\Entity\User());
        return new \Zend\Db\TableGateway\TableGateway('user', $dbAdapter, null, $resultSetPrototype);
    }

}