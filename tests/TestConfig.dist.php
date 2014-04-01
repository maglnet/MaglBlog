<?php

return array(
	// currently there's no test config
	'doctrine' => array(
		'connection' => array(
			// default connection name
			'orm_default' => array(
				'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
				'params' => array(
					'path' => 'data/db.sqlite',
					'charset' => 'utf8',
				)
			)
		)
	),
	'service_manager' => array(
		'use_defaults' => true,
		'factories' => array(
		),
	),
//	'view_manager' => array(
//        'display_not_found_reason' => false,
//        'display_exceptions'       => false,
//        'doctype'                  => 'HTML5',
//        'not_found_template'       => false,
//        'exception_template'       => false,
//        'template_map' => array(
//            'error'           => false,
//        ),
//        'template_path_stack' => array(
//         //   __DIR__ . '/../view',
//        ),
//	),
);
