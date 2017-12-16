<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @var $slug
	 *
	 * @ORM\Column(type="string", unique=true, length=255)
	 */
	private $slug;

	/**
	 * @var $title
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $title;

	/**
	 * @var $body
	 *
	 * @ORM\Column(type="text")
	 */
	private $body;

	/**
	 * @var $metaTitle
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $metaTitle;

	/**
	 * @var $metaDescription
	 *
	 * @ORM\Column(type="string", length=555)
	 */
	private $metaDescription;

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
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * @param mixed $slug
	 */
	public function setSlug( $slug ): void {
		$this->slug = $slug;
	}

	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle( $title ): void {
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * @param mixed $body
	 */
	public function setBody( $body ): void {
		$this->body = $body;
	}

	/**
	 * @return mixed
	 */
	public function getMetaTitle() {
		return $this->metaTitle;
	}

	/**
	 * @param mixed $metaTitle
	 */
	public function setMetaTitle( $metaTitle ): void {
		$this->metaTitle = $metaTitle;
	}

	/**
	 * @return mixed
	 */
	public function getMetaDescription() {
		return $this->metaDescription;
	}

	/**
	 * @param mixed $metaDescription
	 */
	public function setMetaDescription( $metaDescription ): void {
		$this->metaDescription = $metaDescription;
	}


}