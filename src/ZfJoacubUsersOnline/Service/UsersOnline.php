<?php

namespace ZfJoacubUsersOnline\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;
use ZfJoacubMoviesList\Entity\UsersOnline as FriendEntity;
use Zend\Http\PhpEnvironment\RemoteAddress;
use ZfJoacubMoviesList\Entity\VideoVisits;
use ZfJoacubUsersOnline\Entity\Register;
use Nette\Diagnostics\Debugger;

/**
 * ZfJoacubNotificationCenter service manager factory
 */
class UsersOnline implements FactoryInterface 
{
	protected $sl;
	
	/**
	 * 
	 * @var EntityManager
	 */
	protected $em;
	
	protected $isOnline = array();
	
	protected $userRegister = array();
	
    /**
     * Factory method for FileBank Manager service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return \FileBank\Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
    	$this->sl = $serviceLocator;
    	$this->em = $this->sl->get(
    			'doctrine.entitymanager.orm_default');
        return $this;
    }
    
    public function getlapsedTime()
    {
    	$config = $this->sl->get('config');
    	$lapsedTime = $config['ZfJoacubUsersOnline']['lapsed_time'];
    	return $lapsedTime;
    }
    
    
	public function isOnline($user)
    {
    	if(isset($this->isOnline[$user->getId()])) 
    		return $this->isOnline[$user->getId()];
    	$lapsedTime = $this->getlapsedTime();
    	
    	$registerEntity = $this->getOrRegister($user);
    	
    	$lastConnect = $registerEntity->getLastConnect();
    	$lastConnect instanceof \DateTime;
    	
    	$diff = $lastConnect->getTimestamp() - time();
    	
    	$this->isOnline[$user->getId()] = ($diff >= $lapsedTime);
    	return $this->isOnline[$user->getId()];
    }
    
    public function lastConnect($user, $viewIsOnline = true, $stringIsCOnnect = 'Conectado')
    {
    	if($viewIsOnline) {
    		if($this->isOnline($user)) {
    			return $stringIsCOnnect;
    		}
    	}
    	$registerEntity = $this->getOrRegister($user);
    	return $this->sl->get('viewrenderer')->dateDiff($registerEntity->getLastConnect());
    }
    
    /**
     * 
     * @param unknown $user
     * @return ZfJoacubUsersOnline\Entity\Register
     */
    protected function getOrRegister($user)
    {
    	if(isset($this->userRegister[$user->getId()]))
    		return $this->userRegister[$user->getId()];
    	$em = $this->sl->get('zf_joacub_users_online_doctrine_em');
    	$em instanceof EntityManager;
    	$repo = $em->getRepository('ZfJoacubUsersOnline\Entity\Register');
    	$registerEntity = $repo->findOneBy(array('user' => $user));
    	if(!$registerEntity) {
    		$registerEntity = new Register();
    		$registerEntity->setUser($user);
    		
    		$auth = $this->sl->get('zfcuser_auth_service');
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
    	
    	$this->userRegister[$user->getId()] = $registerEntity;
    	
    	return $registerEntity;
    }
    
}