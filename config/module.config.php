<?php

return array(
    'router' => array(
        'routes' => array(
            'swagger-doc' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/api/documentation',
                    'defaults' => array(
                        'controller' => 'SwaggerModule\Controller\Documentation',
                        'action'     => 'display'
                    )
                )
            )
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'SwaggerModule\Controller\Documentation' => 'SwaggerModule\Controller\DocumentationController'
        )
    ),

    'view_manager' => array(
        'template_map' => array(
            'swagger-module/documentation/display'  => __DIR__ . '/../view/swagger-module/documentation/display.phtml',
            'swagger-module/documentation/endpoint' => __DIR__ . '/../view/swagger-module/documentation/endpoint.phtml',
            'swagger-module/documentation/resource' => __DIR__ . '/../view/swagger-module/documentation/resource.phtml',
        ),
    ),
);
