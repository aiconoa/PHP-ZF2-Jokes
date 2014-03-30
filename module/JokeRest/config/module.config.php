<?php

return array(
    'router' => array(
        'routes' => array(
            'rest:joke' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/rest/jokes[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'JokeRest\Controller\JokeRestfulController'
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
    ),
    'controllers' => array(
        'invokables' => array(
            'JokeRest\Controller\JokeRestfulController' => 'JokeRest\Controller\JokeRestfulController'
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);

?>
