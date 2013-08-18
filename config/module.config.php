<?php
namespace ZfJoacubUsersOnline;
return array(
	'asset_manager' => array(
		'resolver_configs' => array(
			'paths' => array(
				__DIR__ . '/../public/'
			)
		)
	),
	'doctrine' => array(
		'driver' => array(
			__NAMESPACE__ . '_entity' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					__NAMESPACE__ . '\Entity' =>  __NAMESPACE__ . '_entity'
				),
			),
		),
	
	),
	'router' => array(
		'routes' => array(
			'users-online-detector' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/users-online-detector',
					'defaults' => array(
						'controller' => __NAMESPACE__ . '\Controller\Detector',
						'action' => 'index'
					)
				)
			),
		)
	),
	'controllers' => array(
		'invokables' => array(
			__NAMESPACE__ . '\Controller\Detector' =>  __NAMESPACE__ . '\Controller\DetectorController',
		)
	),
	'service_manager' => array(
		'aliases' => array(
			'zf_joacub_users_online_doctrine_em' => 'Doctrine\ORM\EntityManager'
		)
	),
	__NAMESPACE__ => array(
		'lapsed_time' => 30
	)
);