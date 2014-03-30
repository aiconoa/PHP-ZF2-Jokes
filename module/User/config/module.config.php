<?php

return array(
    'router' => array(
        'routes' => array(
            'user:login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user/login',
                    'defaults' => array(
                        'controller' => 'User\Controller\UserController',
                        'action'     => 'login',
                    ),
                ),
            ),
            'user:logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user/logout',
                    'defaults' => array(
                        'controller' => 'User\Controller\UserController',
                        'action'     => 'logout',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'JokeAccessService' => 'User\Service\JokeAccessService'
        ),
        'factories' => array(
            'AuthenticationAdapter' => function($sm) {
                    $authAdapter = new \Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        'user',
                        'username',
                        'password',
                        null
                    );

                    return $authAdapter;
                },
            'AuthenticationService' => function ($sm) {
                    $auth = new \Zend\Authentication\AuthenticationService(null, $sm->get('AuthenticationAdapter'));
                    return $auth;
                },
            'UserService' => function ($sm) {
                    $userService = new \User\Service\UserService($sm->get('Zend\Db\Adapter\Adapter'));
                    return $userService;
                },

            'UserTableGateway' => 'User\Factories\UserTableGatewayFactory',
            'RoleTableGateway' => 'User\Factories\RoleTableGatewayFactory',
        ),
        'aliases' => array(
            //for the view helper identity http://framework.zend.com/manual/2.2/en/modules/zend.view.helpers.identity.html
            'Zend\Authentication\AuthenticationService' => 'AuthenticationService',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'User\Controller\UserController' => 'User\Controller\UserController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

?>
