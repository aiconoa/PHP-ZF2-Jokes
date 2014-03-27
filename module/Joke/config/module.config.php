<?php

return array(
    'router' => array(
        'routes' => array(
            'jokes' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/jokes[/]',
                    'defaults' => array(
                        'controller' => 'Joke\Controller\Joke',
                        'action'     => 'list',
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
            'Joke\Service\JokeService' => 'Joke\Service\MockJokeService'
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
