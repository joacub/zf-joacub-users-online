<?php

namespace ZfJoacubUsersOnline\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Doctrine\ORM\EntityManager;
use ZfJoacubUsersOnline\Entity\Register;

class UsersOnline extends AbstractHelper
{
	/**
	 * 
	 * @var unknown
	 */
	protected $sm;
	
	protected $userRegister = null;
	
	protected $isOnline = null;
	
	public function __construct($sm)
	{
		$this->sm = $sm;
	}
    
	/**
	 * 
	 * @param string $user
	 * @return \ZfJoacubUsersOnline\Entity\Register|\ZfJoacubUsersOnline\View\Helper\UsersOnline
	 */
    public function __invoke($user = null)
    {
        if($user !== null) {
        	return $this->getOrRegister($user);
        }
	
		return $this;
        
    }
    
    public function isOnline($user)
    {
    	if($this->isOnline !== null) 
    		return $this->isOnline;
    	$config = $this->sm->getServiceLocator()->get('config');
    	$lapsedTime = $config['ZfJoacubUsersOnline']['lapsed_time'];
    	
    	$registerEntity = $this->getOrRegister($user);
    	
    	$lastConnect = $registerEntity->getLastConnect();
    	$lastConnect instanceof \DateTime;
    	
    	$diff = $lastConnect->getTimestamp() - time();
    	
    	$this->isOnline = ($diff <= $lapsedTime);
    	return $this->isOnline;
    }
    
    public function lastConnect($user, $viewIsOnline = true, $stringIsCOnnect = 'Conectado')
    {
    	if($viewIsOnline) {
    		if($this->isOnline($user)) {
    			return $stringIsCOnnect;
    		}
    	}
    		
    	$registerEntity = $this->getOrRegister($user);
    	return $this->dateDiff($registerEntity->getLastConnect());
    }
    
    /**
     * 
     * @param unknown $user
     * @return ZfJoacubUsersOnline\Entity\Register
     */
    protected function getOrRegister($user)
    {
    	if($this->userRegister !== null)
    		return $this->userRegister;
    	$em = $this->sm->getServiceLocator()->get('zf_joacub_users_online_doctrine_em');
    	$em instanceof EntityManager;
    	$repo = $em->getRepository('ZfJoacubUsersOnline\Entity\Register');
    	$registerEntity = $repo->findOneBy(array('user' => $user));
    	if(!$registerEntity) {
    		$registerEntity = new Register();
    		$registerEntity->setUser($user);
    		
    		$auth = $this->sm->getServiceLocator()->get('zfcuser_auth_service');
    		if ($auth->hasIdentity()) {
    			if($auth->getIdentity()->getId() == $user->getId()) {
    				$registerEntity->setLastConnect(new \DateTime('now'));
    			} else {
    				$registerEntity->setLastConnect($user->getCreated());
    			}
    		}
    		
    		$registerEntity->setLastConnect($user->getCreated());
    		$em->persist($registerEntity);
    		$em->flush($registerEntity);
    	}
    	
    	$this->userRegister = $registerEntity;
    	
    	return $registerEntity;
    }
}
