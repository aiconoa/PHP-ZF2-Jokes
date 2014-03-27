<?php

return array(
    'router' => array(
        'routes' => array(
            'jokes' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/jokes',
                    'defaults' => array(
                        'controller' => 'Joke\Controller\Joke',
                        'action'     => 'list',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/edit/:id',
                            'defaults' => array(
                                'action' => 'edit',
                            )
                        ),
                    ),
                    'delete' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'action' => 'delete',
                            )
                        ),
                    ),
                ),
            ),
            'joke' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/jokes/:id[-:slug]',
                    'constraints' => array(
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Joke\Controller\Joke',
                        'action'     => 'show',
                    ),
                ),
            ),

            'addJoke' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/jokes/add',
                    'constraints' => array(
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Joke\Controller\Joke',
                        'action'     => 'add',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            //'Joke\Service\JokeService' => 'Joke\Service\MockJokeService'
            'Joke\Service\JokeService' => 'Joke\Service\DbJokeService'
        ),
        'factories' => array(
            'JokeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new \Zend\Db\ResultSet\HydratingResultSet(new \Zend\Stdlib\Hydrator\ClassMethods(), new \Joke\Entity\Joke());
//                    $resultSetPrototype->setArrayObjectPrototype(new Joke());
                    return new \Zend\Db\TableGateway\TableGateway('joke', $dbAdapter, null, $resultSetPrototype);
                },
        ),
        'aliases' => array(
            'JokeService' => 'Joke\Service\JokeService',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Joke\Controller\Joke' => 'Joke\Controller\JokeController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

?>
