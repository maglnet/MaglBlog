<?php

return array(
    // currently there's no test config
//	'doctrine' => array(
//		'connection' => array(
//			// default connection name
//			'orm_default' => array(
//				'driverClass' => 'Doctrine\DBAL\Driver\PDOSqlite\Driver',
//				'params' => array(
//					'path' => 'data/db.sqlite',
//					'charset' => 'utf8',
//				)
//			)
//		)
//	),
//	'service_manager' => array(
//		'use_defaults' => true,
//		'factories' => array(
//		),
//	),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/view/dummy-layout.phtml',
            'error'               => __DIR__ . '/view/dummy-layout.phtml',
            '404'               => __DIR__ . '/view/dummy-layout.phtml',
        ),
    ),
);
