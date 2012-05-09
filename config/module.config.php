<?php
return array(
	'di' => array(
		'instance'	=> array(
			'SwaggerModule\Factory\Swagger' => array(
				'parameters' => array(
					'path' => null,
				),
			),
		),
		'definition' => array(
			'class' => array(
				// Swagger factory setup
				'Swagger\Swagger' => array(
					'instantiator' => array(
						'SwaggerModule\Factory\Swagger',
						'get'
					),
				),
				'SwaggerModule\Factory\Swagger' => array(
					'methods' => array(
						'get' => array(
							'path' => array(
								'required' => false,
							),
						),
					),
				),
			),
		),				
	),
);