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
	protected $onlineService;

	public function __construct ($sm)
	{
		$this->onlineService = $sm->getServiceLocator()->get('users_online');
	}

	/**
	 *
	 * @param string $user        	
	 * @return \ZfJoacubUsersOnline\Entity\Register \ZfJoacubUsersOnline\View\Helper\UsersOnline
	 */
	public function __invoke ($user = null)
    {
       return $this->onlineService;
	
        
    }
    
}
