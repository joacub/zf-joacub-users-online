<?php

namespace ZfJoacubUsersOnline\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Zend\Form\Annotation as Form;

/**
 *
 * @author Johan
 * @ORM\Entity
 * @ORM\Table(name="joacub_users_online_register")
 */
class Register
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="ZfJoacubUser\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id", nullable=false)
     */
    protected $user;
    
    /**
     * fecha de conexion
     * @ORM\Column(type="datetime")
     */
    protected $lastConnect;
	/**
	 * @return the $id
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId ($id)
	{
		$this->id = $id;
	}

	/**
	 * @return the $user
	 */
	public function getUser ()
	{
		return $this->user;
	}

	/**
	 * @param field_type $user
	 */
	public function setUser ($user)
	{
		$this->user = $user;
	}

	/**
	 * @return the $lastConnect
	 */
	public function getLastConnect ()
	{
		return $this->lastConnect;
	}

	/**
	 * @param field_type $lastConnect
	 */
	public function setLastConnect ($lastConnect)
	{
		$this->lastConnect = $lastConnect;
	}

    
}