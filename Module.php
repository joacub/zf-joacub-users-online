<?php
namespace ZfJoacubUsersOnline;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\MvcEvent;
use ZfJoacubUsersOnline\View\Helper\UsersOnline;

class Module implements BootstrapListenerInterface
{

	/**
	 * Get Module Configuration
	 *
	 * @return mixed
	 */
	public function getConfig ()
	{
		$config = include __DIR__ . '/config/module.config.php';
		return $config;
	}

	public function getAutoloaderConfig ()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
				)
			)
		);
	}
	
	/*
	 * (non-PHPdoc) @see
	 * \Zend\ModuleManager\Feature\BootstrapListenerInterface::onBootstrap()
	 */
	public function onBootstrap (\Zend\EventManager\EventInterface $e)
	{
		$e->getApplication()
			->getEventManager()
			->attach(MvcEvent::EVENT_RENDER, array(
			$this,
			'onRender'
		), 1000);
	}

	public function onRender (MvcEvent $e)
	{
		$renderer = $e->getApplication()
			->getServiceManager()
			->get('viewrenderer');
		$renderer->headScript()->appendFile($renderer->basePath('zf-joacub-users-online/js/detector.js'));
	}
	
	public function getViewHelperConfig ()
	{
		return array(
			'factories' => array(
				'zfJoacubUsersOnline' => function  ($sm)
				{
					return new UsersOnline($sm);
				}
			)
			
		);
	}
}
