<?php

return array(
    'router' => array(
        'routes' => array(
            'swagger-resources' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/api/docs',
                    'defaults' => array(
                        'controller' => 'SwaggerModule\Controller\Documentation',
                        'action'     => 'display'
                    )
                )
            ),

            'swagger-resource-detail' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/api/docs/:resource',
                    'defaults' => array(
                        'controller' => 'SwaggerModule\Controller\Documentation',
                        'action'     => 'details'
                    )
                )
            )
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'SwaggerModule\Controller\Documentation' => 'SwaggerModule\Controller\DocumentationController'
        )
    )
);
