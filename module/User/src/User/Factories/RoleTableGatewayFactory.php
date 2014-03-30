<?php

namespace User\Factories;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleTableGatewayFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new \Zend\Db\ResultSet\HydratingResultSet(new \Zend\Stdlib\Hydrator\ClassMethods(), new \User\Entity\Role());
        return new \Zend\Db\TableGateway\TableGateway('role', $dbAdapter, null, $resultSetPrototype);
    }

}