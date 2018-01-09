<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="FeedBackRepository")
 * @ORM\Table(name="contacts")
 */
class FeedBack
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 * @var $id
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255, options={"default": ""})
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=255, options={"default": ""})
	 */
	private $email;

	/**
	 * @ORM\Column(type="text")
	 */
	private $message;

	public function __construct()
	{
		$this->name = '';
		$this->email = '';
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

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ): void {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail( $email ): void {
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param mixed $message
	 */
	public function setMessage( $message ): void {
		$this->message = $message;
	}

}