<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @var $firstName
	 */
	private $firstName;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @var $lastName
	 */
	private $lastName;

	public function __construct()
	{
		parent::__construct();
		$this->firstName = "Ivan";
		$this->lastName = "Baraban";
	}

	/**
	 * @return mixed
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * @param mixed $firstName
	 */
	public function setFirstName( $firstName ): void {
		$this->firstName = $firstName;
	}

	/**
	 * @return mixed
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * @param mixed $lastName
	 */
	public function setLastName( $lastName ): void {
		$this->lastName = $lastName;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ): void {
		$this->id = $id;
	}
}