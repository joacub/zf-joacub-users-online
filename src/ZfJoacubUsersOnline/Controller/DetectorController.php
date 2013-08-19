<?php
namespace ZfJoacubUsersOnline\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use ZfJoacubUsersOnline\Entity\Register;

class DetectorController extends AbstractActionController
{

	public function indexAction ()
	{
		$em = $this->getServiceLocator()->get('zf_joacub_users_online_doctrine_em');
		$em instanceof EntityManager;
		
		if ($this->zfcUserAuthentication()->hasIdentity()) {
			$registerRepo = $em->getRepository('ZfJoacubUsersOnline\Entity\Register');
			
			$user = $this->zfcUserAuthentication()->getIdentity();
			
			$userRegister = $registerRepo->findOneBy(array('user' => $user));
			
			if(!$userRegister) {
				$userRegister = new Register();
				$userRegister->setUser($user);
			}
				
			$userRegister->setLastConnect(new \DateTime('now'));
			$em->persist($userRegister);
			$em->flush($userRegister);
			
			return new JsonModel(array(
				time()
			));
			
		}
		
		return new JsonModel(array(
			'no user'
		));
	}
}
