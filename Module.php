<?php
namespace ZfJoacubUsersOnline;

class Module
{
	/**
	 * Get Module Configuration
	 * @return mixed
	 */
	public function getConfig()
	{
		$config = include __DIR__ . '/config/module.config.php';
		return $config;
	}
	
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
    	
        return array(
            'factories' => array(
            	'dateDiff' => function($sm) {
            		return new DateDiff();
            	},
            	
            ),
        );
    }
}
